<?php

namespace Members\Bundle\ManagementBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Members\Bundle\ManagementBundle\Entity\Follow;
use Faker;



class LoadFollowData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $om)
    {
        
        $faker = Faker\Factory::create();
        
        for($i=0; $i< 5; $i++)
        {
            for($j=0; $j<5; $j++)
            {
                
                if($this->getReference('user-follow'.$i)!= $this->getReference('user-follow'.$j)){
                $follow= new Follow();
                
                //die(var_dump($this->getReference('user-follow'.$i)));
                $follow->setFollower($this->getReference('user-follow'.$i));
                $follow->setFollowed($this->getReference('user-follow'.$j));


                $om->persist($follow);
                $om->flush();
                }
       
                
            }
        

        
       
        }

    }
    
    public function getOrder()
    {
        
        return 3;
    }
    
    
}

