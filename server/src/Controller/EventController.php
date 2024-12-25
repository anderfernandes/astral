<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Show;
use App\Model\EventDto;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventController extends AbstractController
{
    /***
     * Returns events happening between $start end $end.
     * If $start and $end are not set, returns all events for the current day.
     * If $start is greater than $end, $end will change to the end of the day of $start.
     */
    #[Route('/events', name: 'events_index', methods: ['GET'], format: 'json')]
    public function index(EventRepository $events, Request $request): Response
    {
        $start = $request->query->has('start')
            ? (new \DateTime())->setTimestamp($request->query->getInt('start'))
            : (new \DateTime())->setTime(0, 0, 0);

        $end = $request->query->has('end')
            ? new \DateTime($request->query->getString('end'))
            : (new \DateTime())->setTime(23, 59, 59);

        if ($start > $end) {
            $start = $start->setTime(23, 59, 59);
        }

        $query = $events->createQueryBuilder('e')
            ->where('e.starting >= :start')
            ->setParameter('start', $start)
            ->AndWhere('e.ending <= :end')
            ->setParameter('end', $end)
            ->getQuery();

        return $this->json(['data' => $query->execute()]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/events', name: 'events_create', methods: ['POST'], format: 'json')]
    public function create(
        #[MapRequestPayload] EventDto $eventDto,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        // Check if event type exists
        $eventType = $entityManager->getRepository(EventType::class)->find($eventDto->typeId);

        if (null === $eventType) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        // Check if shows exist
        $qb = $entityManager->getRepository(Show::class)->createQueryBuilder('s');

        $shows = $qb
            ->where($qb->expr()->in('s.id', $eventDto->shows))
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->execute();

        if (null === $shows) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        if ($eventDto->starting > $eventDto->ending) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        $event = new Event();

        $event->setStarting((new \DateTime())->setTimestamp($eventDto->starting))
            ->setEnding((new \DateTime())->setTimestamp($eventDto->ending))
            ->setIsPublic(false)
            ->setSeats($eventDto->seats)
            ->setType($eventType)
            ->setCreator($this->getUser());

        foreach ($shows as $show) {
            $event->addShow($show);
        }

        $errors = $validator->validate($event);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($event);
        $entityManager->flush();

        return $this->json(['data' => $event->getId()]);
    }

    #[Route('/events/{id}', name: 'events_show', methods: ['GET'], format: 'json')]
    public function show(Event $event): Response
    {
        return $this->json($event);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/events/{id}', name: 'events_update', methods: ['PUT'], format: 'json')]
    public function update(
        #[MapRequestPayload] EventDto $eventDto,
        Event $event,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        if ($eventDto->starting > $eventDto->ending) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        // Check if event type exists
        $eventType = $entityManager->getRepository(EventType::class)->find($eventDto->typeId);

        if (null === $eventType) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        // Check if shows exist
        $qb = $entityManager->getRepository(Show::class)->createQueryBuilder('s');

        $shows = $qb
            ->where($qb->expr()->in('s.id', $eventDto->shows))
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->execute();

        if (null === $shows) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        $event->setStarting((new \DateTime())->setTimestamp($eventDto->starting))
            ->setEnding((new \DateTime())->setTimestamp($eventDto->ending))
            ->setIsPublic(false)
            ->setSeats($eventDto->seats)
            ->setType($eventType);

        foreach ($shows as $show) {
            $event->addShow($show);
        }

        $errors = $validator->validate($event);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($event);
        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
