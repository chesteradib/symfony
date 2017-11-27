<?php

namespace Members\Bundle\ManagementBundle\Entity;


class FollowServices {

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function doesAUserFollowAUser($er, $ed)
    {
            $em = $this->entityManager;

            $query = $em->createQuery(
                'SELECT count(f)
                FROM MembersManagementBundle:Follow f               
                WHERE f.follower = :wer_id
                AND f.followed = :wed_id'
                )->setParameter('wer_id', $er)->setParameter('wed_id', $ed);
            $n = $query->getResult();
            $does = (boolean)(int)$n[0][1];
         
       return $does; 
    }
    
    public function getNumberOfFollowersOfUser($shop_id)
    {
            $em = $this->entityManager;

            $query = $em->createQuery(
                'SELECT count(f)
                FROM MembersManagementBundle:Follow f               
                WHERE f.followed = :wed_id'
                )->setParameter('wed_id', $shop_id);
            $n = $query->getResult();
            
       return (int)$n[0][1]; 
    }
    
    public function getNumberOfFollowedsByCurrentUser($user)
    {
        $em = $this->entityManager;

        $query = $em->createQuery(
            'SELECT count(f)
            FROM MembersManagementBundle:Follow f               
            WHERE f.follower = :wer_id'
            )->setParameter('wer_id', $user);
        $n = $query->getResult();
            
        return (int)$n[0][1]; 
    }
    

    
    public function getFollowersAsEntities($shop_id)
    {
        $em= $this->entityManager;
           
        $query = $em->createQuery(
            'SELECT f
            FROM MembersManagementBundle:Follow f           
            WHERE f.followed = :wed_id
            ORDER BY f.lastDate DESC'
        )->setParameter('wed_id', $shop_id);
                   
        $n= $query->getResult();
           
        return $n;  
    }
    
    
    public function getFollowedsAsEntities($shop_id)
    {
        $em= $this->entityManager;
           
        $query = $em->createQuery(
            'SELECT f
            FROM MembersManagementBundle:Follow f           
            WHERE f.follower = :wer_id'
        )->setParameter('wer_id', $shop_id);
                   
        $n= $query->getResult();
           
        return $n;  
    }
    
    
    public function getNewFollowers($shop_id)
    {
           $em= $this->entityManager;
           
           $query = $em->createQuery(
                'SELECT f
                FROM MembersManagementBundle:Follow f            
                WHERE f.followed = :wed_id
                AND f.followSeen= :seen'
                )->setParameters(array(
                    'wed_id' => $shop_id,
                    'seen' => false
                ));
                   
           $n= $query->getResult();
           
           return $n;
        
    }
    
    public function getFollowByFollowerAndFollowed($current_user_id, $follower_id)
    {
           $em= $this->entityManager;
           
           $query = $em->createQuery(
                'SELECT f
                FROM MembersManagementBundle:Follow f            
                WHERE f.followed = :wed_id
                AND f.follower= :wer_id'
                )->setParameters(array(
                    'wer_id' => $follower_id,
                    'wed_id' => $current_user_id
                ));
                   
           $n= $query->getResult();
           return $n[0];
        
    }
    
    public function getNumberOfFollowsNotSeenByFollowed($current_user_id)
    {
           $em= $this->entityManager;
           
           $query = $em->createQuery(
                'SELECT count(f)
                FROM MembersManagementBundle:Follow f               
                WHERE f.followed = :wed_id
                AND f.followSeen =:seen'
                )->setParameters(array(
                    'wed_id' => $current_user_id,
                    'seen' => false
                ));
                   
           $n= $query->getResult();
           
           return (int)$n[0][1];
        
    }
    
     
    /* This service method was suggested bu SO user
     *  on 11/11/2015 and not yet used,
     * if its perfomrance is berrer, embrace it */
    public function getFollowers2($shop_id)
    {
           $em= $this->entityManager;
           
           $query = $em->createQuery(
                'SELECT IDENTITY(f.follower) AS id
                FROM MembersManagementBundle:Follow f          
                WHERE f.followed = :wed_id'
                )->setParameter('wed_id', $shop_id);
                   
           $n= $query->getResult();
           
           return $n;
        
    }
       public function getFollowers($shop_id)
    {
        $em= $this->entityManager;
           
        $query = $em->createQuery(
            'SELECT u.id
            FROM MembersManagementBundle:Follow f, MembersManagementBundle:User u            
            WHERE f.followed = :wed_id
            AND u.id= f.follower'
        )->setParameter('wed_id', $shop_id);
                   
        $n= $query->getResult();
           
        return $n;  
    }
        public function getFolloweds($shop_id)
    {
        $em= $this->entityManager;
           
        $query = $em->createQuery(
            'SELECT u.id
            FROM MembersManagementBundle:Follow f, MembersManagementBundle:User u            
            WHERE f.follower = :wed_id
            AND u.id= f.followed'
        )->setParameter('wed_id', $shop_id);
                   
        $n= $query->getResult();
           
        return $n;  
    }
    


    
}
?>
