<?php //

namespace Shop\Bundle\ManagementBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Shop\Bundle\ManagementBundle\Entity\Place;

use Faker;



Class LoadPlaceData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    public function load(ObjectManager $om)
    {
        
        $places = array(
            'Kenitra'
        );
        foreach($places as $key => $value)
        {

            $place= new Place();
            $place->setName($value);
            
            $om->persist($place);
            $om->flush();
        }
    }
    
    public function getOrder()
    {
        
        return 1;
    }
}

