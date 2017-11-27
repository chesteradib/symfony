<?php

namespace Members\Bundle\ManagementBundle\DataFixtures\ORM;


use Members\Bundle\ManagementBundle\Entity\ProfilePhoto;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class LoadProfilePhotoData extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $om) {

        $faker = Faker\Factory::create();
        
        for($i=0; $i<5; $i++)
        {
            $profilePhoto = new ProfilePhoto();

            $profilePhoto->setWidthVsHeight(2);

            $profilePhoto->setPath('index'. $i .'.jpeg');

            $this->addReference('user-profilePh'.$i, $profilePhoto);

            $om->persist($profilePhoto);
            $om->flush();
        }
        
        
    }
    
    public function getOrder() {
        return 1;
    }   
    
    
    
}