<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\SaleMemo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaleMemoController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/sales/{id}/memos', methods: ['POST'], format: 'json')]
    public function create(
        Sale $sale,
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
    ): Response {
        $payload = $request->getPayload();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $memo = new SaleMemo(
            content: $payload->getString('content'),
            author: $user,
            sale: $sale
        );

        $errors = $validator->validate($memo);

        if (count($errors) > 0) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($memo);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
