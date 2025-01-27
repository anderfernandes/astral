<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\UserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index', methods: ['GET'], format: 'json')]
    public function index(UserRepository $users): JsonResponse
    {
        return $this->json([
            'data' => $users->findAll(),
        ]);
    }

    #[Route('/users', name: 'user_create', methods: ['POST'], format: 'json')]
    public function create(
        #[MapRequestPayload] UserDto $userDto,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
    ): Response {
        $user = new User(
            email: $userDto->email,
            firstName: $userDto->firstName,
            lastName: $userDto->lastName,
            dateOfBirth: $userDto->dateOfBirth,
            address: $userDto->address,
            city: $userDto->city,
            state: $userDto->state,
            zip: $userDto->zip,
            country: $userDto->country,
            phone: $userDto->phone,
        );

        $user->setPassword($passwordHasher->hashPassword($user, $userDto->password));

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->json(['data' => $user->getId()], Response::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'users_show', methods: ['GET'], format: 'json')]
    public function show(User $user): Response
    {
        return $this->json($user);
    }

    #[Route('/users/{id}', name: 'users_update', methods: ['PUT'], format: 'json')]
    public function update(
        User $user,
        #[MapRequestPayload] UserDto $userDto,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
    ): Response {
        $user
            ->setEmail($userDto->email)
            ->setPassword($passwordHasher->hashPassword($user, $userDto->password))
            ->setFirstName($userDto->firstName)
            ->setLastName($userDto->lastName)
            ->setAddress($userDto->address)
            ->setCity($userDto->city)
            ->setState($userDto->state)
            ->setZip($userDto->zip)
            ->setCountry($userDto->country ?? 'United States')
            ->setPhone($userDto->phone)
            ->setDateOfBirth($userDto->dateOfBirth)
            ->setIsActive(false);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
