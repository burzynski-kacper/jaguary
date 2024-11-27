<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $course = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $semester = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type_of_course = null;

    /**
     * @var Collection<int, Lecturer>
     */
    #[ORM\ManyToMany(targetEntity: Lecturer::class, inversedBy: 'subjects')]
    private Collection $lecturers;

    #[ORM\Column(nullable: true)]
    private ?int $nr_of_hours = null;

    #[ORM\Column(nullable: true)]
    private ?int $ects = null;

    public function __construct()
    {
        $this->lecturers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

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

    public function getSemester(): ?string
    {
        return $this->semester;
    }

    public function setSemester(?string $semester): static
    {
        $this->semester = $semester;

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

    /**
     * @return Collection<int, Lecturer>
     */
    public function getLecturers(): Collection
    {
        return $this->lecturers;
    }

    public function addLecturer(Lecturer $lecturer): static
    {
        if (!$this->lecturers->contains($lecturer)) {
            $this->lecturers->add($lecturer);
        }

        return $this;
    }

    public function removeLecturer(Lecturer $lecturer): static
    {
        $this->lecturers->removeElement($lecturer);

        return $this;
    }

    public function getNrOfHours(): ?int
    {
        return $this->nr_of_hours;
    }

    public function setNrOfHours(?int $nr_of_hours): static
    {
        $this->nr_of_hours = $nr_of_hours;

        return $this;
    }

    public function getEcts(): ?int
    {
        return $this->ects;
    }

    public function setEcts(?int $ects): static
    {
        $this->ects = $ects;

        return $this;
    }
}
