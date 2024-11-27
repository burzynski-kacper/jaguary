<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $courses = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'department')]
    private Collection $rooms;

    /**
     * @var Collection<int, Lecturer>
     */
    #[ORM\ManyToMany(targetEntity: Lecturer::class, mappedBy: 'departments')]
    private Collection $lecturers;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->lecturers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourses(): ?string
    {
        return $this->courses;
    }

    public function setCourses(?string $courses): static
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setDepartment($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getDepartment() === $this) {
                $room->setDepartment(null);
            }
        }

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
            $lecturer->addDepartment($this);
        }

        return $this;
    }

    public function removeLecturer(Lecturer $lecturer): static
    {
        if ($this->lecturers->removeElement($lecturer)) {
            $lecturer->removeDepartment($this);
        }

        return $this;
    }
}
