<?php

namespace App\Helper;

use App\Entity\Specialty;

class SpecialtyFactory
{
    public function createSpecialty(string $json): Specialty
    {
        $json = json_decode($json);

        $specialty = new Specialty();
        $specialty->setDescription($json->description);

        return $specialty;
    }
}