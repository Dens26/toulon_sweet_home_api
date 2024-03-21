<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource()]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['read:accommodation:collection'])]
    private ?\DateTimeImmutable $startOfReservation = null;

    #[ORM\Column]
    #[Groups(['read:accommodation:collection'])]
    private ?\DateTimeImmutable $endOfReservation = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nbrOfPerson = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Accommodation $accommodation = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartOfReservation(): ?\DateTimeImmutable
    {
        return $this->startOfReservation;
    }

    public function setStartOfReservation(\DateTimeImmutable $startOfReservation): static
    {
        $this->startOfReservation = $startOfReservation;

        return $this;
    }

    public function getEndOfReservation(): ?\DateTimeImmutable
    {
        return $this->endOfReservation;
    }

    public function setEndOfReservation(\DateTimeImmutable $endOfReservation): static
    {
        $this->endOfReservation = $endOfReservation;

        return $this;
    }

    public function getNbrOfPerson(): ?int
    {
        return $this->nbrOfPerson;
    }

    public function setNbrOfPerson(int $nbrOfPerson): static
    {
        $this->nbrOfPerson = $nbrOfPerson;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAccommodation(): ?Accommodation
    {
        return $this->accommodation;
    }

    public function setAccommodation(?Accommodation $accommodation): static
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
