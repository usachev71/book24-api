<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
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
    private ?int $balance;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="account", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $userOwner;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitAccount", orphanRemoval=true)
     */
    private $debitTransaction;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="creditAccount", orphanRemoval=true)
     */
    private $creditTransaction;

    public function __construct()
    {
        $this->debitTransaction = new ArrayCollection();
        $this->creditTransaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getUserOwner(): ?User
    {
        return $this->userOwner;
    }

    public function setUserOwner(User $userOwner): self
    {
        $this->userOwner = $userOwner;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDebitTransaction(): Collection
    {
        return $this->debitTransaction;
    }

    public function addDebitTransaction(Transaction $debitTransaction): self
    {
        if (!$this->debitTransaction->contains($debitTransaction)) {
            $this->debitTransaction[] = $debitTransaction;
            $debitTransaction->setDebitAccount($this);
        }

        return $this;
    }

    public function removeDebitTransaction(Transaction $debitTransaction): self
    {
        if ($this->debitTransaction->contains($debitTransaction)) {
            $this->debitTransaction->removeElement($debitTransaction);
            // set the owning side to null (unless already changed)
            if ($debitTransaction->getDebitAccount() === $this) {
                $debitTransaction->setDebitAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getCreditTransaction(): Collection
    {
        return $this->creditTransaction;
    }

    public function addCreditTransaction(Transaction $creditTransaction): self
    {
        if (!$this->creditTransaction->contains($creditTransaction)) {
            $this->creditTransaction[] = $creditTransaction;
            $creditTransaction->setCreditAccount($this);
        }

        return $this;
    }

    public function removeCreditTransaction(Transaction $creditTransaction): self
    {
        if ($this->creditTransaction->contains($creditTransaction)) {
            $this->creditTransaction->removeElement($creditTransaction);
            // set the owning side to null (unless already changed)
            if ($creditTransaction->getCreditAccount() === $this) {
                $creditTransaction->setCreditAccount(null);
            }
        }

        return $this;
    }
}
