<?php

namespace App\DataFixtures;

use App\Entity\Appeal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $appealsData = ['divan' => '+7(999)999-99-99', 'anonymous' => '+0(000)000-00-00'];

        foreach ($appealsData as $customer => $phone) {
            $appeal = new Appeal();
            $appeal->setCustomer($customer);
            $appeal->setPhone($phone);
            $manager->persist($appeal);
        }

        $manager->flush();
    }
}
