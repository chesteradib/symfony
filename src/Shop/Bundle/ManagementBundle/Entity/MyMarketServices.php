<?php

namespace Shop\Bundle\ManagementBundle\Entity;


use Doctrine\ORM\Query\ResultSetMapping;
 
class MyMarketServices {

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function getLatestPostsByFolloweds($current_user_id)
    {
        $em=$this->entityManager;
        
        $rsm= new ResultSetMapping();
        
        $rsm->addEntityResult('ShopManagementBundle:Post', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'post_date', 'postDate');
        $rsm->addMetaResult('p', 'post_user_id', 'post_user_id');
        $rsm->addScalarResult('countF', 'countF');
         
        $query=$em->createNativeQuery('SELECT p.*,  count(f.last_date) as countF
            FROM `post` AS p
            JOIN (SELECT * FROM `follow` WHERE follower_id=? ) AS f
            ON p.post_user_id= f.followed_id
            AND p.post_date > f.last_date
            GROUP BY p.post_user_id
            ORDER BY p.post_date DESC', $rsm);
        $query->setParameter(1, $current_user_id);        
        
        $n= $query->getResult();

        return $n;
    }
    
    public function getPostsByFolloweds($current_user_id, $page, $articlesPerPage)
    {
        $em=$this->entityManager;
        $offset= $page * $articlesPerPage;
        
        $rsm= new ResultSetMapping();
        
        $rsm->addEntityResult('ShopManagementBundle:Post', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'post_date', 'postDate');
        $rsm->addMetaResult('p', 'post_user_id', 'post_user_id');
        $rsm->addMetaResult('p', 'post_main_image_path', 'post_main_image_path');
        $rsm->addMetaResult('p', 'post_title', 'postTitle');
        $rsm->addMetaResult('p', 'post_price', 'postPrice');
         
        $query=$em->createNativeQuery('SELECT p.*
            FROM `post` AS p
            JOIN (SELECT * FROM `follow` WHERE follower_id=? ) AS f
            ON p.post_user_id= f.followed_id
            AND p.post_status = ?
            ORDER BY p.post_date DESC
            LIMIT ? OFFSET ?
            ', $rsm);
        $query->setParameter(1, $current_user_id)
                 ->setParameter(2,'p')
                ->setParameter(3,$articlesPerPage)
                ->setParameter(4, $offset);        
        
        $n= $query->getResult();
        //die(var_dump($n));
        return $n;
    }
}
?>
