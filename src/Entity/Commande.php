<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCommande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;



     /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="dateCommande", type="datetime", nullable=true)
     */
    private $datecommande;

   
    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Description cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Description must be at least {{ limit }} characters long.",
     *     maxMessage="Description cannot be longer than {{ limit }} characters."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="Description must be a string."
     * )
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="montantTotal", type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\NotBlank(message="Montant total cannot be blank.")
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d{1,2})?$/",
     *     message="Montant total must be a valid number with up to two decimal places."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="Montant total must be a string."
     * )
     */
    private $montanttotal;
public function getIdcommande(): ?int
{
    return $this->idCommande;
}

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(?\DateTimeInterface $datecommande): self
    {
        $this->datecommande = $datecommande;

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

    public function getMontanttotal(): ?string
    {
        return $this->montanttotal;
    }

    public function setMontanttotal(?string $montanttotal): self
    {
        $this->montanttotal = $montanttotal;

        return $this;
    }
    // Inside the Commande entity
public function __toString(): string
{
    return (string) $this->idCommande;
}

}
