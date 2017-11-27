<?php


namespace Members\Bundle\ManagementBundle\DataFixtures\ORM;

use Members\Bundle\ManagementBundle\Entity\Message;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class loadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    
  public function  load(ObjectManager $om)
  {
        $faker = Faker\Factory::create();
        
        for($i=0; $i< 200; $i++)
        {
              
              $message = new Message();
              
              $a = (int)($i / 40);
              $b = 5 - $a;
              $c= (int)($i / 5);
                        
              $message->setMessageSeen(false);
              $message->setMessageContent($faker->text);
              $message->setMessageDate($faker->DateTime());
              $message->setPostOwner($this->getReference('message-post-owner'.$a));
              $message->setSender($this->getReference('sender-message'.$a));
              $message->setReceiver($this->getReference('receiver-message'.($b-1)));
              $message->setPost($this->getReference('message-post'.$c));


              $om->persist($message);
              $om->flush();
        }
      }
      
      public function getOrder() {
          return 5;
      }
    
}