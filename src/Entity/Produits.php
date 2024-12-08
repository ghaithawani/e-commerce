<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 */
class Produits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank(message="Nom is required")
     * @Assert\Length(
     *      min=2,
     *      max=30,
     *      minMessage="nom must be at least {{ limit }} characters long",
     *      maxMessage="nom cannot be longer than {{ limit }} characters"
     * )
     */
    private ?string $nom = null;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="prix is required")
     */
    private ?float $prix = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\NotBlank(message="description is required")
     * @Assert\Length(
     *      min=8,
     *      max=1000,
     *      minMessage="description must be at least {{ limit }} characters long",
     *      maxMessage="description cannot be longer than {{ limit }} characters"
     * )
     */
    private ?string $description = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\NotBlank(message="categorie is required")
     * @Assert\Choice(
     *      choices={"Électronique", "Mode", "Maison et Jardin", "Beauté et Soins Personnels", "Sports et Loisirs", "Livres et Médias", "Alimentation et Boissons", "Santé et Bien-être", "Bébés et Enfants", "Animaux de compagnie"},
     *      message="Invalid category selected"
     * )
     */
    private ?string $categorie = null;

    /**
     * @ORM\Column(type=Types::DATE_MUTABLE, nullable=true)
     * @Assert\NotBlank(message="date is required")
     * @Assert\Range(
     *      min="2024-01-01",
     *      max="2024-12-31",
     *      minMessage="Date must be in the year 2024",
     *      maxMessage="Date must be in the year 2024"
     * )
     */
    private ?\DateTimeInterface $dateajout = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDateajout(): ?\DateTimeInterface
    {
        return $this->dateajout;
    }

    public function setDateajout(?\DateTimeInterface $dateajout): static
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom . ' - ' . $this->categorie . ' - ' . $this->prix . ' - ' . $this->description;
    }
}
