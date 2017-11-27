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
        $i=0;
        
        foreach($categories as $key => $value)
        {

            $category= new Category();
            $category->setName($key);
            $category->setParent(null);
            
            if(count($value)>0) $category->setHasChildren(true);
            else  $category->setHasChildren(false);

            $om->persist($category);
            $om->flush();
               
            if(is_array($value))
            {      
                foreach($value as $key2 => $value2)
                {
                    $category2= new Category();
                    $category2->setName($value2);
                    $category2->setParent($category);
                    $category2->setHasChildren(false);
                    
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

