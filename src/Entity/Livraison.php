<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="fk_idvehicule", columns={"id_vehicule"})})
 * @ORM\Entity
 */
class Livraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="idlivraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlivraison;
/**
 * @var string|null
 *
 * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
 * @Assert\NotBlank(message="Adresse cannot be blank.")
 * @Assert\Type(
 *     type={"string", "numeric"},
 *     message="Adresse must be a string or a number."
 * )
 * @Assert\Length(
 *     max=255,
 *     maxMessage="Adresse cannot be longer than {{ limit }} characters."
 * )
 */
private $adresse;

/**
 * @var string|null
 *
 * @ORM\Column(name="destinataire", type="string", length=255, nullable=true)
 * @Assert\NotBlank(message="Destinataire cannot be blank.")
 * @Assert\Type(
 *     type="string",
 *     message="Destinataire must be a string."
 * )
 * @Assert\Length(
 *     max=255,
 *     maxMessage="Destinataire cannot be longer than {{ limit }} characters."
 * )
  * @Assert\Regex(
 *     pattern="/^[a-zA-Z0-9\s]+$/",
 *     message="Event name can only contain letters, numbers, and spaces."
 * )
 */
private $destinataire;


    /**
     * @var string|null
     *
     * @ORM\Column(type="datetime", length=255)
     */
    private $dateLivraison = null;

    /**
     * @ORM\ManyToOne(targetEntity="Vehicule")
     * @ORM\JoinColumn(name="id_vehicule", referencedColumnName="idvehicule")
     */
    private $vehicule;

    public function getIdlivraison(): ?int
    {
        return $this->idlivraison;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDestinataire(): ?string
    {
        return $this->destinataire;
    }

    public function setDestinataire(?string $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }
}
