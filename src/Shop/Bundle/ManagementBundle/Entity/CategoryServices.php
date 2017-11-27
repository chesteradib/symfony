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
        
        $finalArray= array();

        $parentCategories= $em->getRepository('ShopManagementBundle:Category')->findBy(
                array(
                    'parent'=> null)
                );
        
        foreach($parentCategories as $parentCategory)
        {
            $childArray= array();
            
            $childCategories= $em->getRepository('ShopManagementBundle:Category')->findBy(
                array(
                    'parent'=> $parentCategory->getId())
                );
            
            foreach($childCategories as $childCategory)
            {
                $childArray[]= $childCategory;
            }   
            $finalArray[]= array($parentCategory,$childArray);
            
        }
        return $finalArray;
        
    }
}
?>
