<?php

namespace App\Controller;

use App\Entity\EventType;
use App\Model\EventTypeDto;
use App\Repository\EventTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    ): Response {
        $eventType = new EventType();

        $eventType
            ->setName($eventTypeDto->name)
            ->setDescription($eventTypeDto->description)
            ->setColor($eventTypeDto->color)
            ->setBackgroundColor($eventTypeDto->backgroundColor)
            ->setIsPublic($eventTypeDto->isPublic)
            ->setIsActive($eventTypeDto->isActive)
            ->setCreator($this->getUser());

        $errors = $validator->validate($eventType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
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
    ): Response {
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

        $entityManager->persist($eventType);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
