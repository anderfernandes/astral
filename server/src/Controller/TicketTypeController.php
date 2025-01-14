<?php

namespace App\Controller;

use App\Entity\TicketType;
use App\Repository\EventTypeRepository;
use App\Repository\TicketTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TicketTypeController extends AbstractController
{
    #[Route('/ticket-types', name: 'ticket-types_index', methods: ['GET'], format: 'json')]
    public function index(TicketTypeRepository $ticketTypes): Response
    {
        $ticketTypes = $ticketTypes->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->execute();

        return $this->json(['data' => $ticketTypes]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/ticket-types', name: 'ticket-types_create', methods: ['POST'], format: 'json')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        EventTypeRepository $eventTypes,
    ): Response {
        $payload = $request->getPayload();

        $ticketType = new TicketType(
            name: $payload->getString('name'),
            description: $payload->getString('description'),
            price: $payload->getInt('price'),
            isActive: $payload->getBoolean('isActive'),
            isCashier: $payload->getBoolean('isCashier'),
            isPublic: $payload->getBoolean('isPublic'),
            creator: $this->getUser()
        );

        $errors = $validator->validate($ticketType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($ticketType);

        // handle allowed event types
        if ($payload->has('eventTypes')) {
            foreach ($payload->all('eventTypes') as $eventTypeId) {
                $eventType = $eventTypes->find($eventTypeId);

                if (null === $eventType) {
                    return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $ticketType->addEventType($eventType);
                //$entityManager->persist($eventType);
            }
        }

        $entityManager->persist($ticketType);

        $entityManager->flush();

        return $this->json(['data' => $ticketType->getId()], Response::HTTP_CREATED);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/ticket-types/{id}', name: 'ticket-types_update', methods: ['PUT'], format: 'json')]
    public function update(
        TicketType $ticketType,
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        $payload = $request->getPayload();

        $ticketType
            ->setName($payload->getString('name'))
            ->setDescription($payload->getString('description'))
            ->setPrice($payload->getInt('price'))
            ->setIsActive($payload->getBoolean('isActive'))
            ->setIsCashier($payload->getBoolean('isCashier'))
            ->setIsPublic($payload->getBoolean('isPublic'))
            ->setUpdatedAt(new \DateTimeImmutable());

        $errors = $validator->validate($ticketType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($ticketType);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }

    #[Route('/ticket-types/{id}', name: 'ticket-types_show', methods: ['GET'], format: 'json')]
    public function show(TicketType $ticketType): Response
    {
        return $this->json($ticketType);
    }
}
