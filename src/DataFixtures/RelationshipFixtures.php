<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Relationship;

class RelationshipFixtures extends AppFixtures
{
    public function load(ObjectManager $manager)
    {
        $data = ['Father', 'Mother', 'Legal guardian', 'Son', 'Daughter', 'Brother', 'Sister', 'Grandfather', 'Grandmother', 'Uncle', 'Aunt', 'Cousin', 'Niece', 'Nephew'];

        foreach ($data as $k => $v) {
            $relationship = $this->find($manager, Relationship::class, ['relationship' => $v]);
            if (!$relationship) {
                $relationship = new Relationship();
                $relationship->setRelationship($v);
            }

            $relationship->setStatus(1);
            $manager->persist($relationship);
        }

        $manager->flush();
    }
}
