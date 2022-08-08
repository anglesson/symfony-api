<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Helper\DoctorFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private DoctorFactory $doctorFactory;

    public function __construct(EntityManagerInterface $entityManager, DoctorFactory $doctorFactory)
    {
        $this->entityManager = $entityManager;
        $this->doctorFactory = $doctorFactory;
    }

    /**
     * @Route("/doctors", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $bodyRequest = $request->getContent();
        $doctor = $this->doctorFactory->createDoctor($bodyRequest);

        $this->entityManager->persist($doctor);
        $this->entityManager->flush();
        return new JsonResponse($doctor);
    }

    /**
     * @Route("/doctors", methods={"GET"})
     */
    public function get(): Response
    {
        $doctorRepository = $this->entityManager->getRepository(Doctor::class);
        $doctorList = $doctorRepository->findAll();
        return new JsonResponse($doctorList);
    }

    /**
     * @Route("/doctors/{id}", methods={"GET"})
     */
    public function getOne(int $id, Request $request): Response
    {
        $doctor = $this->getDoctor($id);
        $status = is_null($doctor) ? Response::HTTP_NO_CONTENT : 200;
        return new JsonResponse($doctor, $status);
    }

    /**
     * @Route("/doctors/{id}", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response
    {
        $bodyRequest = $request->getContent();
        $sendedDoctor = $this->doctorFactory->createDoctor($bodyRequest);

        $doctorFinded = $this->getDoctor($id);

        if(is_null($doctorFinded)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $doctorFinded
            ->setCrm($sendedDoctor->getCrm())
            ->setName($sendedDoctor->getName());

        $this->entityManager->flush();

        return new JsonResponse($doctorFinded);
    }

    /**
     * @Route("/doctors/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $doctor = $this->getDoctor($id);

        if (!$doctor) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($doctor);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     * @return Doctor|null
     */
    private function getDoctor(int $id): ?Doctor
    {
        return $this
            ->entityManager
            ->getRepository(Doctor::class)
            ->find($id);
    }
}