<?php //

namespace Shop\Bundle\ManagementBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Shop\Bundle\ManagementBundle\Entity\Post;
use Shop\Bundle\ManagementBundle\Entity\Image;
use Faker;



Class LoadPostAndImagesData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    public function load(ObjectManager $om)
    {

        $categories = array(
            'informatique' => array(
                'ordinateurs_de_bureau','ordinateurs_portables','tablettes','accessoires_informatiques'
            ),
            'multimedia'=> array(
                'son','jeux_video_et_consoles','televisions','projecteurs','appareils_photo_et_cameras','accessoires_multimedia'
            ),
            'immobilier' => array(
                'appartements','maisons_et_villas','collocation','bureaux','magasins', 'terrains_et_fermes' , 'locations_de_vacances','autre'
            ),
            'la_maison' => array(
                'cuisine', 'meubles','decoration','jardin','outils_de_bricolage', 'autre'
            ),
            'habillement_et_bien_etre' => array(
                'vetements', 'chaussures','montres','bijoux','sacs','beaute','bebe', 'accessoires', 'autre'
            ),
            'emploi' => array(
                'demandes_d_emploi' ,'offres_d_emploi','offres_de_stages','demandes_de_stages'
            ),
            'lecture' => array (
                'livres', 'magazines'
            ),
            'telephones'=> array(
            ),
            'mariage'=> array(
            ),
            'instruments_de_musique'=> array(
            ),
            'sport' => array(
            ),
            'art'=> array(
            ),
            'collections'=> array(
            ),
            'voyages'=> array(
            ),
            'cinema'=> array(
            ),
            'animaux'=> array(
            ),
            'affaires'=> array(
            ),
            'materiels_professionel'=> array(
            ),
            'cours_et_formations'=> array(
            ),
            'services'=> array(
            )
        );
        $z=0;

        foreach($categories as $key => $value)
        {
            $z++;
            if(is_array($value))
            {
                foreach($value as $key2 => $value2)
                {
                    $z++;
                }

            }
        }

        $faker = Faker\Factory::create();
        
        for($i=0; $i< 40; $i++)
        {
        
            $n = (int) ($i / 8);

            $post= new Post();
            $post->setPostTitle($faker->text);
            $post->setBought($faker->boolean);
            $post->setPostContent($faker->text);
            $post->setPostDate($faker->DateTime());
            $post->setPostPrice($faker->randomNumber(2));

            for($m=0; $m<2; $m++)
            {
                $image = new Image();

                $date=$faker->DateTime();
                $image->setUploadDate($date);


                $image->setWidthVsHeight(1);

                $year= $date->format('Y');
                $month= $date->format('m');
                $day= $date->format('d');
                $hour= $date->format('H');

                $subDirString= $year . DIRECTORY_SEPARATOR
                                . $month . DIRECTORY_SEPARATOR
                                . $day . DIRECTORY_SEPARATOR
                                . $hour;
                $targetDir = 'web/uploads/'.$subDirString;

                if (!is_dir($targetDir)) {

                $ret = mkdir($targetDir, 0777, true);
                    if (!$ret) {
                    throw new \RuntimeException("Could not create target directory to move temporary file into.");
                    }
                }

                $myurl= $faker->image($targetDir, 600, 300,'',false);
                var_dump($myurl);
                $image->setPath($myurl);


                $smallfile = $targetDir . '/s_'. $myurl;
                $mediumfile = $targetDir . '/m_'. $myurl;
                $bigfile = $targetDir . '/b_'. $myurl;

                if($myurl)
                {
                if( !copy($targetDir.'/'.$myurl, $smallfile)
                        || !copy($targetDir.'/'.$myurl, $mediumfile)
                        || !copy($targetDir.'/'.$myurl, $bigfile))
                {
                    echo "failed to copy";
                }

                $post->addImage($image);
                if ($m==1 )  $post->setPostMainImagePath($image);

            }






        }
            $post->setPostStatus('p');

            $post->setUser($this->getReference('user-post'.$n));

            //$randomCategoryId = rand(0, $z -1);
            $post->addCategory($this->getReference('post-category0'));

            $this->setReference('message-post'.$i, $post);

            $om->persist($post);
            $om->flush();
            var_dump($post->getId());
    }
    }
    
    public function getOrder()
    {
        
        return 3;
    }
}

