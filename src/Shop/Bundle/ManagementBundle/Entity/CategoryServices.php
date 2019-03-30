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
     * @return array $categories
     */
    public function getAllCategories()
    {
        $em = $this->entityManager;
        $categories = $em->getRepository('ShopManagementBundle:Category')->findBy(
            [],
            ['name' => 'ASC']//,
            //Query::HYDRATE_ARRAY
        );
        $lastChar = '';
        $cats = array();
        foreach($categories as $val) {
            $char = $val->getName()[0]; //first char


            if ($char !== $lastChar) {
                //if ($lastChar !== '')
                   //echo '<br>';

                //echo strtoupper($char).'<br>'; //print A / B / C etc
                $lastChar = $char;
            }

            $cats[$char][] =
                [
                    'name' => $val->getName(),
                    'id' => $val->getId()

            ];
        }

        //die(var_dump($cats));
        /*
        $categories = [
            'A' => [
                [   'name' => "Accessoire",
                    'id'=> '15'
                ],
                [   'name' => "Adib",
                    'id'=> '16'
                ],
            ],
            'D' => [
                [   'name' => "Diour",
                    'id'=> '15'
                ],
                [   'name' => "Dbab",
                    'id'=> '16'
                ],
            ]
        ];*/
        return $cats;
        
    }
}
?>
