<?php

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
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $balance;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="account", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private int $userId;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitAccount")
     */
    private $debitTransaction;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="creditTransaction")
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

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

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
            $creditTransaction->setCreditTransaction($this);
        }

        return $this;
    }

    public function removeCreditTransaction(Transaction $creditTransaction): self
    {
        if ($this->creditTransaction->contains($creditTransaction)) {
            $this->creditTransaction->removeElement($creditTransaction);
            // set the owning side to null (unless already changed)
            if ($creditTransaction->getCreditTransaction() === $this) {
                $creditTransaction->setCreditTransaction(null);
            }
        }

        return $this;
    }
}
