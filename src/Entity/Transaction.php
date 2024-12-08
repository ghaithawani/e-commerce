<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", indexes={@ORM\Index(name="fk_idcommande", columns={"idCommande"})})
 * @ORM\Entity
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="transactionId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $transactionid;
 
    /**
     * @var string|null
     *
     * @ORM\Column(name="sender", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $sender = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="receiver", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $receiver = '';
 /**
     * @var string|null
     *
     * @ORM\Column(name="qrcode", type="string", length=255, nullable=true)
     */
    private $qrcode;

    /**
     * Get the QR code filename.
     */
    public function getQrcode(): ?string
    {
        return $this->qrcode;
    }

    /**
     * Set the QR code filename.
     */
    public function setQrcode(?string $qrcode): self
    {
        $this->qrcode = $qrcode;

        return $this;
    }
    /**
     * @var float|null
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $amount = NULL;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCommande", referencedColumnName="idCommande")
     * })
     */
    private $idcommande;

    public function getTransactionid(): ?int
    {
        return $this->transactionid;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(?string $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(?string $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

   public function getIdcommande(): ?commande
{
    return $this->idcommande ;
}

    public function setIdcommande(?Commande $idcommande): static
    {
        $this->idcommande = $idcommande;

        return $this;
    }


}
