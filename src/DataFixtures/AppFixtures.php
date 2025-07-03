<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\UserInfo;
use App\Entity\Relationship;
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
                    '123Admin!'
                )
            )
            ->setPseudo('admin1')
            ->setName('Admin Admin')
            ->setBio($this->faker->sentence())
        ;

        $manager->persist($userAdmin);

        //Fixtures 30 USERS
        $fakeUsers = [];

        for ($i = 0; $i < 30; $i++) {

            $fakeUser = new UserInfo();

            $fakeUser
                ->setPseudo($this->faker->unique()->userName())
                ->setName($this->faker->name())
                ->setEmail($this->faker->unique()->email())
                ->setStatus($this->faker->randomElement(['active', 'banned', 'deactivated']))
                ->setPassword(
                    $this->passwordHasher->hashPassword(
                        $fakeUser,
                        'user'
                    )
                )
                ->setBio($this->faker->sentence())
            ;

            $manager->persist($fakeUser);

            $fakeUsers[] = $fakeUser;
        }

        foreach ($fakeUsers as $following) {
            // Chaque user suit entre 1 et 5 autres users
            $numberOfFollows = rand(1, 5);
            $follows = [];
            for ($i = 0; $i < $numberOfFollows; $i++) {
                $followed = $this->faker->randomElement($fakeUsers);

                //un user ne peux pas suivre deux fois le meme user 
                if (!in_array($followed, $follows)) {
                    $follows[] = $followed;
                    // Un user ne peut pas se suivre lui-même
                    if ($following !== $followed) {
                        $relationship = new Relationship();
                        $relationship->setFollowing($following);
                        $relationship->setFollowed($followed);

                        // dd($relationship);
                        $manager->persist($relationship);
                    }
                }
            }
        }

        $manager->flush();
    }
}
