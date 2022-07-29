<?php

namespace App\Entity;

use App\Repository\TasksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TasksRepository::class)]
class Tasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

//    #[ORM\Column]
//    private ?int $uid = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Projects $projects = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pomodoros $pomodoros = null;

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getUid(): ?int
//    {
//        return $this->uid;
//    }
//
//    public function setUid(int $uid): self
//    {
//        $this->uid = $uid;
//
//        return $this;
//    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProjects(): ?Projects
    {
        return $this->projects;
    }

    public function setProjects(?Projects $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function getPomodoros(): ?Pomodoros
    {
        return $this->pomodoros;
    }

    public function setPomodoros(?Pomodoros $pomodoros): self
    {
        $this->pomodoros = $pomodoros;

        return $this;
    }
}
