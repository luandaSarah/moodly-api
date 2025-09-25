<?php

namespace App\DataFixtures;

use Faker\Factory;
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

    private function generateUsername($faker, &$usedUsernames, $firstName, $lastName): string
    {
        $adjectives = ["Lazy", "Crazy", "Happy", "Dark", "Silent", "Epic", "Funky", "Pixel", "Cool"];
        $nouns = ["Panda", "Ninja", "Wizard", "Gamer", "Queen", "Dreamer", "Skater", "Traveler", "Cat"];

        do {
            $pattern = $faker->randomElement([
                strtolower($firstName) . "." . strtolower($lastName),         // ex: marie.dupont
                strtolower(substr($firstName, 0, 1)) . strtolower($lastName), // ex: mdupont
                "{adj}{noun}{number}",                                       // ex: LazyPanda42
                "{first}_{noun}{number}",                                    // ex: lucas_cat99
                "iLove_{noun}",                                              // ex: iLove_Ninja
            ]);

            $username = str_replace(
                ["{adj}", "{noun}", "{number}", "{first}"],
                [
                    $faker->randomElement($adjectives),
                    $faker->randomElement($nouns),
                    $faker->numberBetween(1, 999),
                    strtolower($firstName),
                ],
                $pattern
            );
        } while (in_array($username, $usedUsernames));

        $usedUsernames[] = $username;
        return $username;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $usedUsernames = [];

        for ($i = 0; $i < 30; $i++) {
            $firstName = $this->faker->firstName();
            $lastName  = $this->faker->lastName();

            $username = $this->generateUsername($this->faker, $usedUsernames, $firstName, $lastName);
            $email = preg_replace('/[^a-z0-9._]/', '', strtolower($username)) . "@example.com";

            $user = new UserInfo();
            $user
                ->setName("$firstName $lastName")
                ->setPseudo($username)
                ->setEmail($email)
                ->setPassword($this->passwordHasher->hashPassword($user, '123User!'))
                ->setBio($this->faker->sentence(10));

            $users[] = $user;
            $manager->persist($user);
        }

        foreach ($users as $following) {
            // Chaque user suit entre 1 et 5 autres users
            $numberOfFollows = rand(2, 29);
            $follows = [];
            for ($i = 0; $i < $numberOfFollows; $i++) {
                $followed = $this->faker->randomElement($users);

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
