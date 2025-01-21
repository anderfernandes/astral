<?php

namespace App\Controller;

use App\Entity\Show;
use App\Entity\ShowType;
use App\Repository\ShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ShowController extends AbstractController
{
    #[Route('/shows', name: 'shows_index', methods: ['GET'], format: 'json')]
    public function index(ShowRepository $shows): Response
    {
        return $this->json(['data' => $shows->findAll()]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/shows', name: 'shows_create', methods: ['POST'], format: 'json')]
    public function create(
        // #[MapRequestPayload] ShowDto $showDto,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Request $request,
    ): Response {
        $payload = $request->getPayload();

        $type = $entityManager->getRepository(ShowType::class)
            ->find($payload->getInt('typeId'));

        if (null == $type) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        $show = new Show(
            name: $payload->getString('name'),
            type: $type,
            duration: $payload->getInt('duration'),
            description: $payload->getString('description'),
            creator: $this->getUser(),
            expiration: $payload->getString('expiration') ? new \DateTime($payload->getString('expiration')) : null,
            trailerUrl: $payload->getString('trailerUrl'),
            isActive: $payload->has('isActive')
        );

        if ($request->files->has('cover')) {
            /**
             * @var $cover UploadedFile
             */
            $cover = $request->files->get('cover');
            $filename = '/'.bin2hex(random_bytes(15)).'.'.$cover->guessExtension();
            (new Filesystem())->copy(
                $cover,
                $this->getParameter('uploads_dir').$filename);
            // $cover->move($this->getParameter('uploads_dir'), $filename);
            $show->setCover($filename);
        }

        $errors = $validator->validate($show);

        if (count($errors) > 0) {
            return $this->json((string) $errors, status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($show);

        $entityManager->flush();

        return $this->json(['data' => $show->getId()], Response::HTTP_CREATED);
    }

    #[Route('/shows/{id}', name: 'shows_show', methods: ['GET'], format: 'json')]
    public function show(Show $show): Response
    {
        return $this->json($show);
    }

    #[Route('/shows/{id}', name: 'shows_update', methods: ['POST', 'PUT'], format: 'json')]
    public function update(
        Show $show,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Request $request,
    ): Response {
        $payload = $request->getPayload();

        $type = $entityManager->getRepository(ShowType::class)->find($payload->getInt('typeId'));

        if (null === $type) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        if ($request->files->has('cover')) {
            /**
             * @var $cover UploadedFile
             */
            $cover = $request->files->get('cover');

            $filename = '/'.bin2hex(random_bytes(15)).'.'.$cover->guessExtension();

            (new Filesystem())->copy(
                $cover,
                $this->getParameter('uploads_dir').$filename);

            $show->setCover($filename);
        } else $show->setCover('default.png');

        $show
            ->setName($payload->getString('name'))
            ->setType($type)
            ->setDuration($payload->getInt('duration'))
            ->setDescription($payload->getString('description'))
            ->setCreator($this->getUser())
            ->setIsActive($payload->has('isActive'))
            ->setTrailerUrl($payload->getString('trailerUrl'))
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setExpiration($payload->getString('expiration') ? new \DateTime($payload->getString('expiration')) : null);

        $errors = $validator->validate($show);

        if (count($errors) > 0) {
            return $this->json((string) $errors, status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($show);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
