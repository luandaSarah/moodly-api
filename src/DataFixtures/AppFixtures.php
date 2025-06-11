<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\UserInfo;
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
        $userAdmin = new UserInfo();

        $userAdmin
            // ->setName('Admin')
            ->setEmail('admin@email.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $userAdmin,
                    'admin123'
                )
            )
            ->setPseudo('admin1')
            ->setName('Admin Admin')
            ->setAvatarUrl('https://i.pinimg.com/736x/53/b1/c0/53b1c07490f8a3290a9b988ff727d236.jpg')
            ->setBio($this->faker->sentence())
        ;

        $manager->persist($userAdmin);

        //Fixtures 30 USERS

        for ($i = 0; $i < 30; $i++) {

            $fakeUsers = new UserInfo();

            $fakeUsers
                ->setPseudo($this->faker->unique()->userName())
                ->setName($this->faker->name())
                ->setEmail($this->faker->unique()->email())
                ->setStatus($this->faker->randomElement(['active', 'banned', 'deactivated']))
                ->setPassword(
                    $this->passwordHasher->hashPassword(
                        $fakeUsers,
                        'user'
                    )
                )
                ->setAvatarUrl($this->faker->randomElement([
                    'https://i.pinimg.com/736x/3b/65/26/3b65260662482ca6d9501161f071eacf.jpg',
                    'https://i.pinimg.com/736x/d6/e9/92/d6e99220837cb273ad44e0720fd0942a.jpg',
                    'https://i.pinimg.com/736x/ee/19/2d/ee192d11d9469d9b65c9bdcb593f711a.jpg'
                ]))
                ->setBio($this->faker->sentence())
            ;
            // $manager->persist($fakeUsers);
            $manager->persist($fakeUsers);
            // dd($fakeUsers, $fakeUsersInfo);
        }

        $manager->flush();
    }
}
