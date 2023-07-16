<?php

namespace App\Entity;

use App\Repository\RetraitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetraitRepository::class)]
class Retrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $code_recu = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column]
    private ?int $id_compte = null;

    #[ORM\Column]
    private ?int $numero_recu = null;

    #[ORM\Column]
    private ?int $cnumero_recu = null;

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

    public function getCodeRecu(): ?string
    {
        return $this->code_recu;
    }

    public function setCodeRecu(string $code_recu): static
    {
        $this->code_recu = $code_recu;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

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

    public function getNumeroRecu(): ?int
    {
        return $this->numero_recu;
    }

    public function setNumeroRecu(int $numero_recu): static
    {
        $this->numero_recu = $numero_recu;

        return $this;
    }

    public function getCnumeroRecu(): ?int
    {
        return $this->cnumero_recu;
    }

    public function setCnumeroRecu(int $cnumero_recu): static
    {
        $this->cnumero_recu = $cnumero_recu;

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
