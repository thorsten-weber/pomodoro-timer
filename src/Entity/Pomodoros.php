<?php

namespace App\Entity;

use App\Repository\PomodorosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PomodorosRepository::class)]
class Pomodoros
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?int $short_break = null;

    #[ORM\Column]
    private ?int $long_break = null;

    #[ORM\Column(nullable: true)]
    private ?int $cycles = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $cycles_to_long_break = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getShortBreak(): ?int
    {
        return $this->short_break;
    }

    public function setShortBreak(int $short_break): self
    {
        $this->short_break = $short_break;

        return $this;
    }

    public function getLongBreak(): ?int
    {
        return $this->long_break;
    }

    public function setLongBreak(int $long_break): self
    {
        $this->long_break = $long_break;

        return $this;
    }

    public function getCycles(): ?int
    {
        return $this->cycles;
    }

    public function setCycles(?int $cycles): self
    {
        $this->cycles = $cycles;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getCyclesToLongBreak(): ?int
    {
        return $this->cycles_to_long_break;
    }

    public function setCyclesToLongBreak(?int $cycles_to_long_break): self
    {
        $this->cycles_to_long_break = $cycles_to_long_break;

        return $this;
    }
}
