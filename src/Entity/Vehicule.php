<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule", uniqueConstraints={@ORM\UniqueConstraint(name="immatriculation", columns={"immatriculation"})})
 * @ORM\Entity
 */
class Vehicule
{
    /**
     * @var int
     *
     * @ORM\Column(name="idvehicule", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvehicule;

    /**
     * @ORM\OneToMany(targetEntity="Livraison", mappedBy="vehicule", cascade={"persist", "remove"})
     */
    private $livraisons;
    
    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

    /**
     * @return Collection|Livraison[]
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setVehicule($this);
        }

        return $this;
    }

      public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getVehicule() === $this) {
                $livraison->setVehicule(null);
            }
        }

        return $this;
    }
   /**
     * @var string|null
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="La marque ne peut pas être vide.")
     */
    private $marque;
 /**
     * @var string|null
     *
     * @ORM\Column(name="modele", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le modèle ne peut pas être vide.")
     */
    private $modele;

   /**
     * @var int|null
     *
     * @ORM\Column(name="annee", type="integer", nullable=true)
     * @Assert\NotBlank(message="L'année ne peut pas être vide.")
     * @Assert\Range(min=1900, max=2050, minMessage="L'année doit être supérieure ou égale à 1900.", maxMessage="L'année doit être inférieure ou égale à 2050.")
     */
    private $annee;


   /**
     * @var string|null
     *
     * @ORM\Column(name="couleur", type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="La couleur ne peut pas être vide.")
     */
    private $couleur;

   /**
     * @var string|null
     *
     * @ORM\Column(name="immatriculation", type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="L'immatriculation ne peut pas être vide.")
     * @Assert\Length(max=20, maxMessage="L'immatriculation ne peut pas dépasser {{ limit }} caractères.")
     */
    private $immatriculation;

    public function getIdvehicule(): ?int
    {
        return $this->idvehicule;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function __toString(): string
    {
        return $this->immatriculation ?? '';
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }
}
