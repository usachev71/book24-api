<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private array $users = [
        [
            'name' => 'Лилия',
            'email' => 'example1@example.com',
            'balance' => 100
        ],
        [
            'name' => 'Тимофей',
            'email' => 'example2@example.com',
            'balance' => 200
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->users as $userData) {
            $user = new User($userData['name'], $userData['email']);
            $account = new Account();

            $account
                ->setUserOwner($user)
                ->setBalance($userData['balance']);

            $user->setAccount($account);

            $manager->persist($user);
        }
        $manager->flush();
    }
}