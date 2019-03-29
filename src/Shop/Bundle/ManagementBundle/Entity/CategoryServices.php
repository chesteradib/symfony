<?php

namespace Shop\Bundle\ManagementBundle\Entity;
 
 
class CategoryServices{

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }
    
    /* 
     * Get all Categories as object graph
     *      
     */
    public function getAllCategories()
    {
        $em = $this->entityManager;


        $finalArray= $em->getRepository('ShopManagementBundle:Category')->findAll();

        return $finalArray;
        
    }
}
?>
