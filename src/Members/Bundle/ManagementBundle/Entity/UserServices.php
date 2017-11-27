<?php

namespace Members\Bundle\ManagementBundle\Entity;
 
use Doctrine\ORM\Query\ResultSetMapping;



class UserServices {

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

     /* New services of 14 - 04 - 2016 */
    
    public function getNewPostersAndDates($page,$articlesPerPage)
    {
        $em=$this->entityManager;
        
        $rsm= new ResultSetMapping();
        $offset= $page * $articlesPerPage;
        
        $rsm->addEntityResult('MembersManagementBundle:User', 'u');
        $rsm->addFieldResult('u', 'id', 'id');
        $rsm->addFieldResult('u', 'username', 'username');
        $rsm->addFieldResult('u', 'created_at', 'createdAt');
        $rsm->addMetaResult('u', 'profile_picture', 'profile_picture');

         
        $query=$em->createNativeQuery('SELECT u.*, t.maxdt 
                FROM  `fos_user` AS u
                INNER JOIN (SELECT post_user_id, max(post_date) as maxdt 
                FROM  `post`
                WHERE post_status="p"
                group by post_user_id
                order by maxdt desc) AS t
                ON u.id=t.post_user_id
                LIMIT ? OFFSET ?', $rsm);
        $query->setParameter(1, $articlesPerPage)
              ->setParameter(2, $offset);
       
        $n= $query->getResult();
        
        return $n;
    }
    public function getNumberOfNewPosters()
    {
        $em=$this->entityManager;
        
        $rsm= new ResultSetMapping();

        $rsm->addEntityResult('MembersManagementBundle:User', 'u');
        $rsm->addFieldResult('u', 'id', 'id');
        $rsm->addFieldResult('u', 'username', 'username');
        $rsm->addMetaResult('u', 'profile_picture', 'profile_picture');

        $query=$em->createNativeQuery('SELECT u.*, t.maxdt 
                FROM  `fos_user` AS u
                INNER JOIN (SELECT post_user_id, max(post_date) as maxdt
                FROM  `post`
                WHERE post_status="p"
                group by post_user_id
                order by maxdt desc) AS t
                ON u.id=t.post_user_id
                ', $rsm);

       
        $n= $query->getResult();

        return $n;
    }

}
?>
