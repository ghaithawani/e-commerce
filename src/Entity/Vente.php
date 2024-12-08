<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VenteRepository::class)
 */
class Vente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="quantitevendu is required")
     * @Assert\GreaterThan(
     *      value=0,
     *      message="Quantity sold must be a positive number"
     * )
     */
    private ?int $quantitevendu = null;

    /**
     * @ORM\Column(type=Types::DATE_MUTABLE)
     * @Assert\NotBlank(message="date is required")
     * @Assert\Range(
     *      min="2024-01-01",
     *      max="2024-12-31",
     *      minMessage="Date must be in the year 2024",
     *      maxMessage="Date must be in the year 2024"
     * )
     */
    private ?\DateTimeInterface $datevente = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="montant total is required")
     */
    private ?float $montanttotal = null;

    /**
     * @ORM\ManyToOne(targetEntity=Produits::class)
     * @ORM\JoinColumn(name="idProduit", referencedColumnName="id", nullable=false)
     */
    private ?Produits $idProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitevendu(): ?int
    {
        return $this->quantitevendu;
    }

    public function setQuantitevendu(?int $quantitevendu): self
    {
        $this->quantitevendu = $quantitevendu;

        return $this;
    }

    public function getDatevente(): ?\DateTimeInterface
    {
        return $this->datevente;
    }

    public function setDatevente(?\DateTimeInterface $datevente): self
    {
        $this->datevente = $datevente;

        return $this;
    }

    public function getMontanttotal(): ?float
    {
        return $this->montanttotal;
    }

    public function setMontanttotal(?float $montanttotal): self
    {
        $this->montanttotal = $montanttotal;

        return $this;
    }

    public function getIdProduit(): ?Produits
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produits $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }
}
