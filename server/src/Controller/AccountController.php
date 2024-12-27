<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\UserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AccountController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'], format: 'json')]
    public function register(
        #[MapRequestPayload] UserDto $userDto,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        MailerInterface $mailer,
    ): Response {
        $user = new User();

        $user
            ->setEmail($userDto->email)
            ->setPassword($passwordHasher->hashPassword($user, $userDto->password))
            ->setFirstName($userDto->firstName)
            ->setLastName($userDto->lastName)
            ->setAddress($userDto->address)
            ->setCity($userDto->city)
            ->setState($userDto->state)
            ->setZip($userDto->zip)
            ->setCountry('United States')
            ->setPhone($userDto->phone)
            ->setDateOfBirth($userDto->dateOfBirth)
            ->setIsActive(false);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new Response($errors);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        $token = password_hash($user->getEmail(), PASSWORD_DEFAULT);
        $expires = (new \DateTime('+15 minutes'));

        $email = (new TemplatedEmail())
            ->to($user->getEmail())
            ->subject("Activate your {$_ENV['NAME']} account")
            ->htmlTemplate('emails/activate.html.twig')
            ->context([
                'expires' => $expires,
                'name' => 'John Doe',
                'button' => [
                    'text' => 'Activate Account',
                    'href' => "{$_ENV['FRONTEND_URL']}/activate?token=$token&hash={$expires->getTimestamp()}",
                ],
            ]);

        $mailer->send($email);

        return new Response(status: Response::HTTP_OK);
    }

    #[Route('/account', name: 'account', methods: ['GET'], format: 'json')]
    public function account(#[CurrentUser] ?User $user): Response
    {
        if ($user === null) {
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        return $this->json($user);
    }

    #[Route('/account/update', name: 'account_update', methods: ['PUT'], format: 'json')]
    public function update(
        #[CurrentUser] ?User $user,
        #[MapRequestPayload] UserDto $userDto,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
    ): Response {
        if (null === $user) {
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        $user
            ->setEmail($userDto->email)
            ->setPassword($passwordHasher->hashPassword($user, $userDto->password))
            ->setFirstName($userDto->firstName)
            ->setLastName($userDto->lastName)
            ->setAddress($userDto->address)
            ->setCity($userDto->city)
            ->setState($userDto->state)
            ->setZip($userDto->zip)
            ->setCountry('United States')
            ->setPhone($userDto->phone)
            ->setDateOfBirth($userDto->dateOfBirth)
            ->setIsActive(false);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new Response((string) $errors);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }

    #[Route('/login', name: 'login', methods: ['POST'], format: 'json')]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        return new Response(status: Response::HTTP_OK);
    }

    #[Route('/activate', name: 'activate', methods: ['GET'], format: 'json')]
    public function activate(
        Request $request,
        UserRepository $users,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        $token = $request->query->get('token');

        // TODO: HANDLE EXPIRATION

        if (null === $token) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
            // return $this->json(['message' => 'Invalid token'], Response::HTTP_BAD_REQUEST);
        }

        $sql = '
            SELECT email FROM users
            WHERE is_active = false
            ';

        $emails = $entityManager->getConnection()->executeQuery($sql)->fetchFirstColumn();

        foreach ($emails as $email) {
            if (password_verify($email, $token)) {
                $user = $users->findOneBy(['email' => $email]);
                $user->setIsActive(true);
                $user->setActivatedAt();
                // TODO: VERIFED_AT
                $entityManager->persist($user);
                $entityManager->flush();

                return new Response(status: Response::HTTP_OK);
            }
        }

        return new Response(status: Response::HTTP_BAD_REQUEST);
        // return $this->json(['message' => 'Email not found'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/logout', name: 'logout', methods: ['POST'], format: 'json')]
    public function logout(Security $security): Response
    {
        if (null === $this->getUser()) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        $security->logout(false);

        return new Response(status: Response::HTTP_OK);
    }

    #[Route('/forgot', name: 'forgot', methods: ['POST'], format: 'json')]
    public function forgot(Request $request, UserRepository $users, MailerInterface $mailer): Response
    {
        $email = $request->getPayload()->getString('email');

        $user = $users->findOneBy(['email' => $email]);

        if (null === $user) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        $expires = new \DateTime('+15 minutes');
        $token = password_hash($user->getEmail(), PASSWORD_DEFAULT); // TODO: ENCRYPT

        $email = (new TemplatedEmail())
            ->to($user->getEmail())
            ->subject("Reset your {$_ENV['NAME']} account")
            ->htmlTemplate('emails/forgot.html.twig')
            ->context([
                'expires' => $expires,
                'name' => 'John Doe',
                'button' => [
                    'text' => 'Reset Password',
                    'href' => "{$_ENV['FRONTEND_URL']}/reset?token=$token&hash={$expires->getTimestamp()}",
                ],
            ]);

        $mailer->send($email);

        return new Response(status: Response::HTTP_OK);
    }

    #[Route('/reset', name: 'reset', methods: ['POST'], format: 'json')]
    public function reset(
        Request $request,
        UserRepository $users,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        $password = $request->getPayload()->getString('password');
        $passwordConfirmation = $request->getPayload()->getString('passwordConfirmation');

        if ($password !== $passwordConfirmation) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $expires = (new \DateTime())->setTimestamp($request->query->getInt('hash'));

        /*if ((new \DateTime()) > $expires) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }*/

        $token = $request->query->getString('token');

        /*if (!\password_verify($request->getPayload()->getString('email'), $token)) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }*/

        $emails = $entityManager
            ->getConnection()
            ->executeQuery('SELECT email FROM users')
            ->fetchFirstColumn();

        foreach ($emails as $email) {
            if (\password_verify($email, $token)) {
                $user = $users->findOneBy(['email' => $email]);

                if (null === $user) {
                    return new Response(status: Response::HTTP_BAD_REQUEST);
                }

                $user->setPassword(
                    $passwordHasher->hashPassword($user, $password)
                );

                $entityManager->persist($user);
                $entityManager->flush();

                return new Response(status: Response::HTTP_OK);
            }
        }

        return new Response(status: Response::HTTP_BAD_REQUEST);
    }
}
