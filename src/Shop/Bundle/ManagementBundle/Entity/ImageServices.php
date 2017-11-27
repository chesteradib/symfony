<?php

namespace Shop\Bundle\ManagementBundle\Entity;
 
 
class ImageServices{

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

  public function getImagesOfAnArticle($articleId)
    {
        $em = $this->entityManager;
        
        $query = $em->createQuery(
                'SELECT i
                FROM ShopManagementBundle:Image i              
                WHERE i.post = :articleId'
                
                )->setParameter('articleId', $articleId);
        $images = $query->getResult();

        return   $images;   
        
    }
}
?>
