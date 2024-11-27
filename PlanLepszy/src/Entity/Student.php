<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $info = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $course = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type_of_course = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $semester = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): static
    {
        $this->info = $info;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(?string $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getTypeOfCourse(): ?string
    {
        return $this->type_of_course;
    }

    public function setTypeOfCourse(?string $type_of_course): static
    {
        $this->type_of_course = $type_of_course;

        return $this;
    }

    public function getSemester(): ?string
    {
        return $this->semester;
    }

    public function setSemester(?string $semester): static
    {
        $this->semester = $semester;

        return $this;
    }
}
