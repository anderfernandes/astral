<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Show;
use App\Model\EventDto;
use App\Repository\EventRepository;
use App\Repository\EventTypeRepository;
use App\Repository\ShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventController extends AbstractController
{
    #[Route('/events', name: 'events_index', methods: ['GET'], format: 'json')]
    public function index(EventRepository $events): Response
    {
        return $this->json(['data' => $events->findAll()]);
    }

    #[Route('/events', name: 'events_create', methods: ['POST'], format: 'json')]
    public function create(
        #[MapRequestPayload] EventDto $eventDto,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
        ): Response
    {
        // Check if event type exists
        $eventType = $entityManager->getRepository(EventType::class)->find($eventDto->typeId);

        if ($eventType === null)
            return new Response(status: Response::HTTP_BAD_REQUEST);

        // Check if shows exist
        $qb = $entityManager->getRepository(Show::class)->createQueryBuilder('s');

        $shows = $qb
            ->where($qb->expr()->in('s.id', $eventDto->shows))
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->execute();

        if ($shows === null)
            return new Response(status: Response::HTTP_BAD_REQUEST);

        $event = new Event();

        $event->setStarting($eventDto->starting)
            ->setEnding($eventDto->ending)
            ->setIsPublic(false)
            ->setSeats($eventDto->seats)
            ->setType($eventType)
            ->setCreator($this->getUser());

        foreach ($shows as $show)
            $event->addShow($show);

        $errors = $validator->validate($event);

        if (count($errors) > 0)
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);

        $entityManager->persist($event);
        $entityManager->flush();

        return $this->json(['data' => $event->getId()]);
    }

    #[Route('/events/{id}', name: 'events_show', methods: ['GET'], format: 'json')]
    public function show(Event $event): Response
    {
        return $this->json($event);
    }
}