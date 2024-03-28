<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\AccommodationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AccommodationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: [
                'groups' => ['read:accommodation:collection'],
            ]
        ),
        new Get(
            normalizationContext: [
                'groups' => ['read:accommodation:collection', 'read:accommodation:item'],
            ]
        ),
        new Patch(
            denormalizationContext: [
                'groups' => ['patch:accommodation'],
            ]
        ),
    ]
)]
class Accommodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:accommodation:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:accommodation:item', 'patch:accommodation'])]
    private ?string $streetName = null;

    #[ORM\Column(length: 10)]
    #[Groups(['read:accommodation:item', 'patch:accommodation'])]
    private ?string $streetNumber = null;

    #[ORM\Column(length: 5)]
    #[Groups(['read:accommodation:item'])]
    private ?string $postal = null;

    #[ORM\Column(length: 25)]
    #[Groups(['read:accommodation:item'])]
    private ?string $city = null;

    #[ORM\Column(length: 25)]
    #[Groups(['read:accommodation:item'])]
    private ?string $country = null;

    #[ORM\Column]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?bool $available = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?\DateTimeImmutable $availableUntil = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?int $nbrOfRooms = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?int $maxPerson = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private ?int $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'accommodation')]
    #[Groups(['read:accommodation:collection'])]
    private Collection $reservations;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'accommodation')]
    #[Groups(['read:accommodation:collection', 'patch:accommodation'])]
    private Collection $pictures;

    #[ORM\ManyToOne(inversedBy: 'accommodations')]
    #[Groups(['read:accommodation:item'])]
    private ?User $host = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

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

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): static
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): static
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }

    public function getAvailableUntil(): ?\DateTimeImmutable
    {
        return $this->availableUntil;
    }

    public function setAvailableUntil(\DateTimeImmutable $availableUntil): static
    {
        $this->availableUntil = $availableUntil;

        return $this;
    }

    public function getNbrOfRooms(): ?int
    {
        return $this->nbrOfRooms;
    }

    public function setNbrOfRooms(int $nbrOfRooms): static
    {
        $this->nbrOfRooms = $nbrOfRooms;

        return $this;
    }

    public function getMaxPerson(): ?int
    {
        return $this->maxPerson;
    }

    public function setMaxPerson(int $maxPerson): static
    {
        $this->maxPerson = $maxPerson;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setAccommodation($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getAccommodation() === $this) {
                $reservation->setAccommodation(null);
            }
        }

        return $this;
    }

    public function getHost(): ?User
    {
        return $this->host;
    }

    public function setHost(?User $host): static
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setAccommodation($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getAccommodation() === $this) {
                $picture->setAccommodation(null);
            }
        }

        return $this;
    }
}
