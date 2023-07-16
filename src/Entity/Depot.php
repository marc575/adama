<?php

namespace App\Entity;

use App\Repository\DepotRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepotRepository::class)]
class Depot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $id_compte = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private ?int $id_transaction = null;

    #[ORM\Column]
    private ?int $numero_paiement = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getIdCompte(): ?int
    {
        return $this->id_compte;
    }

    public function setIdCompte(int $id_compte): static
    {
        $this->id_compte = $id_compte;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getIdTransaction(): ?int
    {
        return $this->id_transaction;
    }

    public function setIdTransaction(int $id_transaction): static
    {
        $this->id_transaction = $id_transaction;

        return $this;
    }

    public function getNumeroPaiement(): ?int
    {
        return $this->numero_paiement;
    }

    public function setNumeroPaiement(int $numero_paiement): static
    {
        $this->numero_paiement = $numero_paiement;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
