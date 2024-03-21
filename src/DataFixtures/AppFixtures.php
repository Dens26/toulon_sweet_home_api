<?php

namespace App\DataFixtures;

use App\Entity\Accommodation;
use App\Entity\Picture;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Init Faker
        $faker = Factory::create('fr_FR');

        for ($j = 0; $j < 10; ++$j) {
            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $email = $firstName.'.'.$lastName.'@test.com';
            $phoneNumber = '06';
            for ($i = 0; $i < 8; ++$i) {
                $phoneNumber = $phoneNumber.random_int(0, 9);
            }

            // Create user
            $user = new User();
            $user
                ->setEmail($email)
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setUserName($faker->userName())
                ->setPhoneNumber($phoneNumber)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setLastConnection(new \DateTimeImmutable());

            $password = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();

        $users = $this->entityManager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 5; ++$i) {
            $nbrOfRooms = random_int(1, 5);
            $accommodation = new Accommodation();
            $accommodation
                ->setUSer($users[random_int(0, 9)])
                ->setName($faker->streetName)
                ->setDescription($faker->text())
                ->setStreetName($faker->streetName())
                ->setStreetNumber((string) random_int(1, 150))
                ->setPostal((string) random_int(10000, 99999))
                ->setCity('Toulon')
                ->setCountry('France')
                ->setAvailable((bool) random_int(0, 1))
                ->setNbrOfRooms($nbrOfRooms)
                ->setMaxPerson($nbrOfRooms * 2)
                ->setPrice($nbrOfRooms * 60)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($accommodation);
        }
        $manager->flush();

        $accommodations = $this->entityManager->getRepository(Accommodation::class)->findAll();

        foreach ($accommodations as $accommodation) {
            for ($i = 0; $i < random_int(1, 5); ++$i) {
                $picture = new Picture();
                $picture
                    ->setAccommodation($accommodation)
                    ->setName($faker->name())
                    ->setFile('https://source.unsplash.com/featured/200x300')
                    ->setDescription($faker->text())
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUppdatedAt(new \DateTimeImmutable());
                $manager->persist($picture);
            }
        }

        for ($i = 0; $i < 2; ++$i) {
            $accommodation = $accommodations[random_int(0, 4)];
            $today = new \DateTimeImmutable();
            $startOfReservation = $today->modify('+'.(string) random_int(5, 60).' days');
            $endOfReservation = $startOfReservation->modify('+14 days');

            $reservation = new Reservation();
            $reservation
                ->setAccommodation($accommodation)
                ->setUser($users[random_int(0, 9)])
                ->setStartOfReservation($startOfReservation)
                ->setEndOfReservation($endOfReservation)
                ->setNbrOfPerson((int) $accommodation->getMaxPerson())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($reservation);
        }
        $manager->flush();
    }
}
