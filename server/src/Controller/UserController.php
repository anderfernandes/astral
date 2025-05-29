<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\UserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\ByteString;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index', methods: ['GET'], format: 'json')]
    public function index(UserRepository $users): JsonResponse
    {
        $data = $users->createQueryBuilder('u')->orderBy('u.firstName', 'ASC')->getQuery()->execute();

        return $this->json(data: ['data' => $data], context: ['groups' => ['user:list']]);
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
            phone: $userDto->phone
        );

        $user->setPassword($passwordHasher->hashPassword($user, ByteString::fromRandom(32)->toString()));

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json((string) $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
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
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
    ): Response {
        $payload = $request->getPayload();

        $user
            ->setEmail($payload->get('email'))
            // ->setPassword($passwordHasher->hashPassword($user, $payload->get('email')))
            ->setFirstName($payload->get('firstName'))
            ->setLastName($payload->get('lastName'))
            ->setAddress($payload->get('address'))
            ->setCity($payload->get('city'))
            ->setState($payload->get('state'))
            ->setZip($payload->get('zip'))
            ->setCountry('United States')
            ->setPhone($payload->get('phone'))
            ->setIsActive($payload->has('isActive'))
            ->setRoles([$payload->get('role')])
            ->setUpdatedAt(new \DateTimeImmutable());
        // ->setDateOfBirth(new \DateTimeImmutable($payload->get('dateOfBirth')))

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
