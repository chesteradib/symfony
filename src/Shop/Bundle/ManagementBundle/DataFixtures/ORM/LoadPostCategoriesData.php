<?php 

namespace Shop\Bundle\ManagementBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Shop\Bundle\ManagementBundle\Entity\Category;


Class LoadPostCategoriesData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    public function load(ObjectManager $om)
    {
        $categories = array(
            'telephones'=> array(
            ),
            'la_maison' => array(
                'electromenager', 'chambre_a_coucher', 'cuisine', 'meubles','decoration','jardin','outils_de_bricolage', 'autre'
            ),
            'informatique' => array(
                'ordinateurs_de_bureau','ordinateurs_portables','tablettes','accessoires_informatiques', 'autre'
            ),
            'multimedia'=> array(
                'son','jeux_video_et_consoles','televisions','projecteurs','appareils_photo_et_cameras','accessoires_multimedia', 'autre'
            ),
            'immobilier' => array(
                'appartements','maisons_et_villas','collocation','bureaux','magasins', 'terrains_et_fermes' , 'locations_de_vacances','autre'
            ),
            'habillement_et_bien_etre' => array(
                'vetements', 'chaussures','montres','bijoux','sacs','beaute','bebe', 'accessoires', 'autre'
            ),
            'lecture' => array (
                 'livres', 'magazines'
            ),
            'instruments_de_musique'=> array(
            ),
            'sport' => array(
            ),
            'voyages'=> array(
            ),
            'materiels_professionel'=> array(
            ),
            'art'=> array(
            ),
            'collections'=> array(
            ),
            'cinema'=> array(
            ),
            'animaux'=> array(
            ),
            'affaires'=> array(
            ),
            'cours_et_formations'=> array(
            ),
            'services'=> array(
            ),
            'emploi' => array(
                'demandes_d_emploi' ,'offres_d_emploi','offres_de_stages','demandes_de_stages'
            )
        );
        $i=0;

        foreach($categories as $key => $value)
        {

            $category= new Category();
            $category->setName($key);
            $category->setParent(null);

            $om->persist($category);
            $om->flush();

            if(is_array($value))
            {
                foreach($value as $key2 => $value2)
                {
                    $category2= new Category();
                    $category2->setName($value2);
                    $category2->setParent($category);

                    $this->setReference('post-category'.$i, $category2);
                    $i++;

                    $om->persist($category2);
                    $om->flush();

                   }

            }
        }

    }
    
    public function getOrder()
    {
        return 1;
    }
}

