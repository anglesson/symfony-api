<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Repository\SpecialtyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialtyController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SpecialtyRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, SpecialtyRepository $repository) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    #[Route('/specialty', methods: 'POST')]
    public function create(Request $request): Response
    {
        $dataRequest = $request->getContent();
        $dataInJson = json_decode($dataRequest);

        $specilty = new Specialty();
        $specilty->setDescription($dataInJson->description);

        $this->entityManager->persist($specilty);
        $this->entityManager->flush();
        return new JsonResponse($specilty);
    }

    #[Route('/specialty', methods: 'GET')]
    public function getAll(): Response
    {
        $specialtyList = $this->repository->findAll();
        return new JsonResponse($specialtyList);
    }

    #[Route('/specialty/{id}', methods: 'GET')]
    public function getOne(int $id): Response
    {
        $specialty = $this->repository->find($id);
        return new JsonResponse($specialty);
    }

    #[Route('/specialty/{id}', methods: 'PUT')]
    public function update(int $id, Request $request): Response
    {
        $dataRequest = $request->getContent();
        $jsonSpecialty = json_decode($dataRequest);

        $specialty = $this->repository->find($id);
        $specialty->setDescription($jsonSpecialty->description);
        $this->entityManager->flush();

        return new JsonResponse($specialty);
    }

    #[Route('/specialty/{id}', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        $specialty = $this->repository->find($id);
        $this->entityManager->remove($specialty);
        $this->entityManager->flush();
        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}
