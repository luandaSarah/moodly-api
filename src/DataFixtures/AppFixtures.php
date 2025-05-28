<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //Fixtures ADMIN USER
        $userAdmin = new User();

        $userAdmin
            ->setUsername('admin1')
            ->setName('Admin')
            ->setEmail('admin@email.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $userAdmin,
                    'admin123'
                )
            )
        ;

        $manager->persist($userAdmin);

        //Fixtures 30 USERS

        for ($i = 0; $i < 30; $i++) {

            $fakeUsers = new User;


            $fakeUsers
                ->setUsername($this->faker->unique()->userName())
                ->setName("User$i User$i")
                ->setEmail($this->faker->unique()->email())
                ->setStatus($this->faker->randomElement(['active', 'banned', 'deactivated']))
                ->setPassword(
                    $this->passwordHasher->hashPassword(
                        $fakeUsers,
                        'user'
                    )
                )
            ;
            $manager->persist($fakeUsers);
        }

        $manager->flush();
    }
}
