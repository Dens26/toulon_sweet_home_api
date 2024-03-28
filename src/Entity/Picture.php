<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PictureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[ApiResource()]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:accommodation:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?string $file_small = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:accommodation:item', 'patch:accommodation'])]
    private ?string $file_big = null;

    #[Groups(['read:accommodation:item', 'patch:accommodation'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $uppdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?Accommodation $accommodation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFileSmall(): ?string
    {
        return $this->file_small;
    }

    public function setFileSmall(string $file_small): static
    {
        $this->file_small = $file_small;

        return $this;
    }

    public function getFileBig(): ?string
    {
        return $this->file_big;
    }

    public function setFileBig(string $file_big): static
    {
        $this->file_big = $file_big;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getUppdatedAt(): ?\DateTimeImmutable
    {
        return $this->uppdatedAt;
    }

    public function setUppdatedAt(\DateTimeImmutable $uppdatedAt): static
    {
        $this->uppdatedAt = $uppdatedAt;

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
}
