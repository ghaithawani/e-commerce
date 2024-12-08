<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ResponseRepository;

/**
 * @ORM\Table(name="response", indexes={@ORM\Index(name="fk_idrec", columns={"idrec"})})
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $idrep = null;

    // Replace the $idrec property with a Many-To-One association
    /**
     * @ORM\ManyToOne(targetEntity=Reclamation::class, inversedBy="responses")
     * @ORM\JoinColumn(nullable=false, name="idrec", referencedColumnName="idrec")
     */
    private ?Reclamation $reclamation = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $daterep = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $contenurep;

    // Getters and setters...

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getIdrep(): ?int
    {
        return $this->idrep;
    }

    public function getDaterep(): ?\DateTimeInterface
    {
        return $this->daterep;
    }

    public function setDaterep(\DateTimeInterface $daterep): self
    {
        $this->daterep = $daterep;

        return $this;
    }

    public function getContenurep(): ?string
    {
        return $this->contenurep;
    }

    public function setContenurep(string $contenurep): self
    {
        $this->contenurep = $contenurep;

        return $this;
    }
}
