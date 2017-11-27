<?php


namespace Members\Bundle\ManagementBundle\DataFixtures\ORM;

use Members\Bundle\ManagementBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Faker;


class loadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
  
  private $container;
  
  public function setContainer(ContainerInterface $container = null) {
      
      $this->container = $container;
      
  }
  public function  load(ObjectManager $om)
  {
        $faker = Faker\Factory::create();
        
        for($i=0; $i< 5; $i++)
        {      
            $user = new User();

            $this->addReference('user-post'.$i, $user);
            $this->addReference('user-profilePhoto'.$i, $user);
            $this->addReference('sender-message'.$i, $user);
            $this->addReference('receiver-message'.$i, $user);
            $this->setReference('message-post-owner'.$i, $user);
            $this->addReference('user-follow'.$i, $user);

            $tempo_username= $faker->firstName;
            $encoder= $this->container->get('security.encoder_factory')->getEncoder($user);

            $user->setUsername($tempo_username);
            $user->setPassword($encoder->encodePassword($tempo_username, $user->getSalt()));
            
            
            
            
            
            $date=$faker->DateTime();
            
            $user->setCreatedAt($date);
            
            $year= $date->format('Y');
            $month= $date->format('m');

            
            $subDirString= $year . DIRECTORY_SEPARATOR 
                            . $month;
            $targetDir = 'web/pp/'.$subDirString;

            if (!is_dir($targetDir)) {

            $ret = mkdir($targetDir, 0777, true);
                if (!$ret) {
                throw new \RuntimeException("Could not create target directory to move temporary file into.");
                }
            }
     
            //var_dump($myurl);
            

            $user->setDomainName('domain_name');
            $user->setLatitude($faker->latitude);
            $user->setLongitude($faker->longitude);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setEmail($faker->email);
            $user->setStoreDescription($faker->text);
            $user->setEnabled(true);

            $user->setProfilePicture($this->getReference('user-profilePh'.$i));

            $om->persist($user);
            $om->flush();
        }
      }
      
      public function getOrder() {
          return 2;
      }
    
}