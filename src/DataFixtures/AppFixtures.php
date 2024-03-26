<?php

namespace App\DataFixtures;

use App\Entity\Accommodation;
use App\Entity\Picture;
use App\Entity\Reservation;
use App\Entity\User;
use DateTimeImmutable;
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

        $url = 'https://randomuser.me/api/?nat=fr&results=10';
        $result = file_get_contents($url);
        $data = json_decode($result, true);
        for ($j = 0; $j < 10; ++$j) {
            $firstName = $data['results'][$j]['name']['first'];
            $lastName = $data['results'][$j]['name']['last'];
            $email = $data['results'][$j]['email'];
            $phoneNumber = '06' . random_int(10000000, 99999999);
            $picture = $data['results'][$j]['picture']['large'];
            $createdAt = new DateTimeImmutable($data['results'][$j]['registered']['date']);


            // Create user
            $user = new User();
            $user
                ->setEmail($email)
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setUserName($faker->userName())
                ->setPhoneNumber($phoneNumber)
                ->setCreatedAt($createdAt)
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setLastConnection(new \DateTimeImmutable())
                ->setPicture($picture);

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
                ->setHost($users[random_int(0, 9)])
                ->setName('Maison ' . $faker->name())
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
            $urlPictures_small = [
                'https://images.unsplash.com/photo-1568605114967-8130f3a36994?q=80&w=500&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=500&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://plus.unsplash.com/premium_photo-1661858661945-40c62d8fca88?q=80&w=500&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1615874959474-d609969a20ed?q=80&w=500&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1594498653385-d5172c532c00?q=80&w=500&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ];
            $urlPictures_big = [
                'https://images.unsplash.com/photo-1568605114967-8130f3a36994?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://plus.unsplash.com/premium_photo-1661858661945-40c62d8fca88?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1615874959474-d609969a20ed?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1594498653385-d5172c532c00?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ];
            for ($i = 0; $i < 5; ++$i) {
                $picture = new Picture();
                $picture
                    ->setAccommodation($accommodation)
                    ->setName($faker->name())
                    ->setFileSmall($urlPictures_small[$i])
                    ->setFileBig($urlPictures_big[$i])
                    ->setDescription($faker->text())
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUppdatedAt(new \DateTimeImmutable());
                $manager->persist($picture);
            }
        }

        for ($i = 0; $i < 2; ++$i) {
            $accommodation = $accommodations[random_int(0, 4)];
            $today = new \DateTimeImmutable();
            $startOfReservation = $today->modify('+' . (string) random_int(5, 60) . ' days');
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
