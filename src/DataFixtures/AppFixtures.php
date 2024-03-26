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
            $description = "<h2>À propos de ce logement</h2>
            <p>Située à 10 minutes de Pont Audemer, cette maison contemporaine complètement rénovée en 2020 vous permettra de découvrir facilement la Normandie, elle est parfaitement adaptée pour 4 adultes et 2 enfants. En moins de 45 min vous pourrez visiter Le Marais Vernier, Rouen, Le Havre, Honfleur, Deauville mais aussi en 1 heure Etretat, Giverny, Caen…Vous pourrez profiter du jardin : Piscine chauffée à 28° en été, trampoline, cabane, balançoire et les animaux (poules et chats sur place).</p>
            <h3>Le logement</h3>
            <p>La maison est idéale pour les familles qui aiment la nature et les animaux, vous aurez vue sur les chevaux du voisin et disposerez d'équipements sympathiques pour occuper vos enfants comme la cabane sur pilotis avec les poules en dessous, la piscine chauffée à 28° uniquement en été et en hivernage à partir de septembre (donc inaccessible), la balançoire, le trampoline et un panneau de basket ! Des jeux de sociétés et consoles de jeux sont à disposition. Il est fort probable que vous croisiez nos chats pensez à nous prévenir en cas de problème d'allergies.</p>
            <h3>Accès des voyageurs</h3>
            <p>L'accès à la maison est autonome grâce à la boite à clef située au portail.</p>
            <h3>Autres remarques</h3>
            <p>Vous disposerez de tous le confort durant votre séjour pour vos vacances : barbecue, appareils à fondu, raclette et pierrade. TV avec accès à NETFLIX et Prime Vidéo ainsi qu'un vidéo projecteur dans la chambre principale pour vos soirées cinéma.</p>
            <p>La maison est 10 minutes de Pont Audemer, petite ville charmante et très dynamique avec un bon nombre de restaurants pour tous les goûts, un cinéma, un bowling ainsi que divers activités comme le laser game ou encore un escape game.</p>
            <p>Piscine uniquement en été environ de juin à fin septembre.</p>";

            $accommodation = new Accommodation();
            $accommodation
                ->setHost($users[random_int(0, 9)])
                ->setName('Maison ' . $faker->name())
                ->setSubtitle('Un havre de paix')
                ->setDescription($description)
                ->setStreetName($faker->streetName())
                ->setStreetNumber((string) random_int(1, 150))
                ->setPostal('83000')
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
