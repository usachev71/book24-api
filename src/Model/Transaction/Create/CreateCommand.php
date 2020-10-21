<?php

declare(strict_types=1);

namespace App\Model\Transaction\Create;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $from_user;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $to_user;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    public int $amount;
}