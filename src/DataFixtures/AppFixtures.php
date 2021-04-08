<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Article;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for($i=0; $i<20; $i++){
            $users = new Users;
            $users->setEmail($faker->email)
                ->setPassword($this->passwordEncoder->encodePassword($users,'123'))
                ->setRoles(array('ROLE_USER'))
                ->setName($faker->name);
            $this->addReference('user'.$i, $users);
            $manager->persist($users);
            $manager->flush();
        }

        for($i=0; $i<10; $i++){
            $author = $this->getReference('user'.rand(0,19));

        	$article = new Article();
        	$article->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true))
		        	->setContent($faker->text($maxNbChars = 3000))
		        	->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setAuthorId($author);

		    $manager->persist($article);
		    $manager->flush();
        }
    }
}
