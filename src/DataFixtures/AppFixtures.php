<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Director;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');


        $users = [];

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setNameUser($faker->lastName());
            $user->setFirstnameUser($faker->firstName());
            $user->setEmailUser($faker->unique()->safeEmail());
            $user->setPasswordUser('password');
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
            $users[] = $user;
        }
        $categories = [];
        $categoryNames = ['Action', 'Comédie', 'Drame', 'Science-fiction', 'Thriller'];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setNameCat($name);

            $manager->persist($category);
            $categories[] = $category;
        }
        $directors = [];

        for ($i = 0; $i < 5; $i++) {
            $director = new Director();
            $director->setNameDirector($faker->lastName());
            $director->setFirstnameDirector($faker->firstName());
            $director->setDayOfBirth($faker->dateTimeBetween('-70 years', '-30 years'));
            $director->setCountryDirector($faker->country());

            $manager->persist($director);
            $directors[] = $director;
        }
        for ($i = 0; $i < 10; $i++) {
            $movie = new Movie();
            $movie->setTitleMovie($faker->unique()->sentence(3));
            $movie->setSynopsisMovie($faker->paragraph());
            $movie->setCreatedAt(new \DateTime());

            // User (ManyToOne)
            $movie->setUser($faker->randomElement($users));

            // Categories (ManyToMany)
            $movie->addCategory($faker->randomElement($categories));

            // Directors (ManyToMany)
            $movie->addDirector($faker->randomElement($directors));

            $manager->persist($movie);
        }
    }
}
