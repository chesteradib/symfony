<?php

namespace Shop\Bundle\ManagementBundle\Entity;

use Doctrine\ORM\Query;
 
class CategoryServices{

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Find the categories ordered and grouped alphabetically
     *
     * @return array $orderedCategories
     */
    public function getAllCategories()
    {
        $em = $this->entityManager;
        $categories = $em->getRepository('ShopManagementBundle:Category')->findBy(
            [],
            ['name' => 'ASC']
        );

        $lastChar = '';
        $orderedCategories = [];
        foreach($categories as $val) {
            $char = strtoupper($val->getName()[0]);
            if ($char !== $lastChar) {
                $lastChar = $char;
            }

            $orderedCategories[$char][] = [
                    'name' => $val->getName(),
                    'id' => $val->getId()
            ];
        }

        return $orderedCategories;
        
    }
}
?>
