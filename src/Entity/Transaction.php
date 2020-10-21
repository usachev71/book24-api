<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?DateTimeImmutable $date;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="debitTransaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Account $debitAccount;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="creditTransaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Account $creditTransaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDebitAccount(): ?Account
    {
        return $this->debitAccount;
    }

    public function setDebitAccount(?Account $debitAccount): self
    {
        $this->debitAccount = $debitAccount;

        return $this;
    }

    public function getCreditTransaction(): ?Account
    {
        return $this->creditTransaction;
    }

    public function setCreditTransaction(?Account $creditTransaction): self
    {
        $this->creditTransaction = $creditTransaction;

        return $this;
    }
}
