<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Internal\TentativeType;

#[ORM\Entity()]
class Doctor implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 6)]
    private int $crm;

    #[ORM\Column(length: 200)]
    private string $name;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialty $specialty = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCrm(): int
    {
        return $this->crm;
    }

    public function setCrm(int $crm): Doctor
    {
        $this->crm = $crm;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Doctor
    {
        $this->name = $name;
        return $this;
    }

    public function getSpecialty(): ?Specialty
    {
        return $this->specialty;
    }

    public function setSpecialty(?Specialty $specialty): self
    {
        $this->specialty = $specialty;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'crm' => $this->getCrm(),
            'name' => $this->getName(),
            'specialty_id' => $this->getSpecialty()->getId()
        ];
    }
}