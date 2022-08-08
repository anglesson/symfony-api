<?php

namespace App\Helper;

use App\Entity\Doctor;
use App\Repository\SpecialtyRepository;

class DoctorFactory
{
    private SpecialtyRepository $specialtyRepository;

    public function __construct(SpecialtyRepository $specialtyRepository)
    {
        $this->specialtyRepository = $specialtyRepository;
    }

    public function createDoctor(string $json): Doctor
    {
        $json = json_decode($json);
        $speciltyId = $json->specialty_id;
        $specilty = $this->specialtyRepository->find($speciltyId);

        $doctor = new Doctor();
        $doctor
            ->setCrm($json->crm)
            ->setName($json->name)
            ->setSpecialty($specilty);

        return $doctor;
    }
}