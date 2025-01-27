<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventMemo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventMemoController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/events/{id}/memos', methods: ['POST'], format: 'json')]
    public function create(
        Event $event,
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager): Response
    {
        $payload = $request->getPayload();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $eventMemo = new EventMemo(
            content: $payload->getString('content'),
            author: $user,
            event: $event
        );

        $errors = $validator->validate($eventMemo);

        if (count($errors) > 0) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($eventMemo);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
