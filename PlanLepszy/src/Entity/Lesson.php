<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $item = null;

    /**
     * @var Collection<int, Subject>
     */
    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'lessons')]
    private Collection $subject_id;

    /**
     * @var Collection<int, Teacher>
     */
    #[ORM\ManyToMany(targetEntity: Teacher::class, inversedBy: 'lessons')]
    private Collection $teacher_id;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\ManyToMany(targetEntity: Room::class, inversedBy: 'lessons')]
    private Collection $room_id;

    #[ORM\Column]
    private array $json = [];

    #[ORM\Column]
    private ?bool $is_updated = null;

    public function __construct()
    {
        $this->subject_id = new ArrayCollection();
        $this->teacher_id = new ArrayCollection();
        $this->room_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(string $item): static
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjectId(): Collection
    {
        return $this->subject_id;
    }

    public function addSubjectId(Subject $subjectId): static
    {
        if (!$this->subject_id->contains($subjectId)) {
            $this->subject_id->add($subjectId);
        }

        return $this;
    }

    public function removeSubjectId(Subject $subjectId): static
    {
        $this->subject_id->removeElement($subjectId);

        return $this;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeacherId(): Collection
    {
        return $this->teacher_id;
    }

    public function addTeacherId(Teacher $teacherId): static
    {
        if (!$this->teacher_id->contains($teacherId)) {
            $this->teacher_id->add($teacherId);
        }

        return $this;
    }

    public function removeTeacherId(Teacher $teacherId): static
    {
        $this->teacher_id->removeElement($teacherId);

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRoomId(): Collection
    {
        return $this->room_id;
    }

    public function addRoomId(Room $roomId): static
    {
        if (!$this->room_id->contains($roomId)) {
            $this->room_id->add($roomId);
        }

        return $this;
    }

    public function removeRoomId(Room $roomId): static
    {
        $this->room_id->removeElement($roomId);

        return $this;
    }

    public function getJson(): array
    {
        return $this->json;
    }

    public function setJson(array $json): static
    {
        $this->json = $json;

        return $this;
    }

    public function isUpdated(): ?bool
    {
        return $this->is_updated;
    }

    public function setUpdated(bool $is_updated): static
    {
        $this->is_updated = $is_updated;

        return $this;
    }
}
