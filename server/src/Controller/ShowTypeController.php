<?php

namespace App\Controller;

use App\Entity\ShowType;
use App\Model\ShowTypeDto;
use App\Repository\ShowTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ShowTypeController extends AbstractController
{
    #[Route('/show-types', name: 'show-types_index', methods: ['GET'], format: 'json')]
    public function index(ShowTypeRepository $showTypes): Response
    {
        return $this->json(['data' => $showTypes->findAll()]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/show-types', name: 'show-types_create', methods: ['POST'], format: 'json')]
    public function create(
        #[MapRequestPayload] ShowTypeDto $showTypeDto,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        $showType = new ShowType(
            name: $showTypeDto->name,
            description: $showTypeDto->description,
            creator: $this->getUser(),
            isActive: $showTypeDto->isActive
        );

        $errors = $validator->validate($showType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($showType);

        $entityManager->flush();

        return $this->json(['data' => $showType->getId()], Response::HTTP_CREATED);
    }

    #[Route('/show-types/{id}', name: 'show-types_show', methods: ['GET'], format: 'json')]
    public function show(ShowType $showType): Response
    {
        return $this->json($showType);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/show-types/{id}', name: 'show-types_update', methods: ['PUT'], format: 'json')]
    public function update(
        #[MapRequestPayload] ShowTypeDto $showTypeDto,
        ShowType $showType,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        $showType
            ->setName($showTypeDto->name)
            ->setDescription($showTypeDto->description)
            ->setIsActive($showTypeDto->isActive)
            ->setCreator($this->getUser());

        $errors = $validator->validate($showType);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($showType);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
