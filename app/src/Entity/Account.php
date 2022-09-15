<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: Types::FLOAT, options:["default" => 0])]
    private ?float $balance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'balance' => $this->getBalance()
        ];
    }
}
