<?php

namespace App\Controller;

use App\Entity\EventType;
use App\Model\EventTypeDto;
use App\Repository\EventTypeRepository;
use App\Repository\TicketTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventTypeController extends AbstractController
{
    #[Route('/event-types', name: 'event-types_index', methods: ['GET'], format: 'json')]
    public function index(EventTypeRepository $eventTypes): Response
    {
        $eventTypes = $eventTypes->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->execute();

        return $this->json(['data' => $eventTypes]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/event-types', name: 'event-types_create', methods: ['POST'], format: 'json')]
    public function create(
        #[MapRequestPayload] EventTypeDto $eventTypeDto,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Request $request,
        TicketTypeRepository $ticketTypes,
    ): Response {
        $payload = $request->getPayload();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $eventType = new EventType(
            name: $eventTypeDto->name,
            description: $eventTypeDto->description,
            creator: $user,
            isActive: $eventTypeDto->isActive,
            isPublic: $eventTypeDto->isPublic,
            color: $eventTypeDto->color,
            backgroundColor: $eventTypeDto->backgroundColor,
        );

        $errors = $validator->validate($eventType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($payload->has('ticketTypes') && count($payload->all('ticketTypes')) > 0) {
            foreach ($payload->all('ticketTypes') as $ticketTypeId) {
                $ticketType = $ticketTypes->find($ticketTypeId);

                if (null === $ticketType) {
                    continue;
                }

                if ($ticketType->getIsActive()) {
                    $eventType->addTicketType($ticketType);
                }
            }
        }

        $entityManager->persist($eventType);

        $entityManager->flush();

        return $this->json(['data' => $eventType->getId()], Response::HTTP_CREATED);
    }

    #[Route('/event-types/{id}', name: 'event-types_show', methods: ['GET'], format: 'json')]
    public function show(EventType $eventType): Response
    {
        return $this->json($eventType);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/event-types/{id}', name: 'event-types_update', methods: ['PUT'], format: 'json')]
    public function update(
        #[MapRequestPayload] EventTypeDto $eventTypeDto,
        EventType $eventType,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Request $request,
        TicketTypeRepository $ticketTypes,
    ): Response {
        $payload = $request->getPayload();

        $eventType
            ->setName($eventTypeDto->name)
            ->setDescription($eventTypeDto->description)
            ->setColor($eventTypeDto->color)
            ->setBackgroundColor($eventTypeDto->backgroundColor)
            ->setIsPublic($eventTypeDto->isPublic)
            ->setIsActive($eventTypeDto->isActive)
            ->setUpdatedAt(new \DateTimeImmutable());

        $errors = $validator->validate($eventType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($payload->has('ticketTypes')) {
            // DELETE ALL CURRENT ASSOCIATIONS AND ENTER NEW ONES

            $connection = $entityManager->getConnection();

            $query = '
                DELETE FROM event_type_ticket_type
                WHERE event_type_id = :event_type_id
            ';

            $connection->executeQuery($query, ['event_type_id' => $eventType->getId()]);

            // CREATE ASSOCIATIONS

            foreach (array_unique($payload->all('ticketTypes')) as $ticketTypeId) {
                $ticketType = $ticketTypes->find($ticketTypeId);

                if (null === $ticketType) {
                    continue;
                }

                if ($ticketType->getIsActive()) {
                    $eventType->addTicketType($ticketType);
                    $entityManager->persist($ticketType);
                }
            }
        }

        $entityManager->persist($eventType);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
