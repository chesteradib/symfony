<?php
 namespace Shop\Bundle\ManagementBundle\Entity;
 
use Doctrine\ORM\Query\ResultSetMapping;
 
class ServiceName {

    protected $entityManager;
    protected $followManager;

    public function __construct($entityManager,$followManager) {
        $this->entityManager = $entityManager;
        $this->followManager = $followManager;
    }
 /*
  public function getAllPosts2($page, $articlesPerPage)
    {
        $em = $this->entityManager;
        
        $offset= $page * $articlesPerPage;
        $query = $em->createQuery(
                'SELECT p, i
                FROM ShopManagementBundle:Post p
                JOIN ShopManagementBundle:Image i
                WITH p.postMainImagePath = i.id
                WHERE p.postStatus = :ps
                ORDER BY p.postDate DESC'
                
                )->setParameter('ps', 'p')->setFirstResult($offset)->setMaxResults($articlesPerPage);
        $products = $query->getResult();

        return   $products;   
        
    }*/
    
    public function getAllPosts($page, $articlesPerPage)
    {
        $em = $this->entityManager;

        $offset= $page * $articlesPerPage;
        $query = $em->createQuery(
            'SELECT p
            FROM ShopManagementBundle:Post p               
            WHERE p.postStatus = :ps
            ORDER BY p.postDate DESC')
        ->setParameter('ps', 'p')->setFirstResult($offset)->setMaxResults($articlesPerPage);
        $products = $query->getResult();

        return   $products;    
    }
    
    public function getPostsOfSpecificShop($shop_id, $page, $articlesPerPage)
    {
        $em = $this->entityManager;
        
        $offset= $page * $articlesPerPage;
        $query = $em->createQuery(
                'SELECT p
                FROM ShopManagementBundle:Post p               
                WHERE p.user = :user_id
                AND p.postStatus = :ps
                ORDER BY p.postDate DESC'
                
                )->setParameter('ps', 'p')->setParameter('user_id', $shop_id)->setFirstResult($offset)->setMaxResults($articlesPerPage);
                $products = $query->getResult();
                //die(var_dump($products));
        return   $products;   
    }
    
    public function getNumberOfArticles($shop_id)
    {       
        $em = $this->entityManager;

        $query = $em->createQuery(
            'SELECT count(p)
            FROM ShopManagementBundle:Post p               
            WHERE p.user = :user_id
            AND p.postStatus = :ps'
            )->setParameter('user_id', $shop_id)->setParameter('ps', 'p');
        $n = $query->getResult();

        return (int)$n[0][1];   
    } 
    
    
    public function getNumberOfMyMarketArticles($current_user_id)
    {   
        $em=$this->entityManager;
        
        $rsm= new ResultSetMapping();
        
        $rsm->addEntityResult('ShopManagementBundle:Post', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'post_date', 'postDate');
        $rsm->addMetaResult('p', 'post_user_id', 'post_user_id');

         
        $query=$em->createNativeQuery('SELECT p.id
            FROM `post` AS p
            JOIN (SELECT * FROM `follow` WHERE follower_id=? ) AS f
            ON p.post_user_id= f.followed_id
            AND p.post_status = ?
            ORDER BY p.post_date DESC
            ', $rsm);
        $query->setParameter(1, $current_user_id)->setParameter(2, 'p');        
        
        $n= $query->getResult();
        
        return count($n);   
    }
    
    public function getNumberOfAllItems()
    {       
        $em = $this->entityManager;

        $query = $em->createQuery(
            'SELECT count(p)
            FROM ShopManagementBundle:Post p               
            WHERE p.postStatus = :ps'
            )->setParameter('ps', 'p');
        $n = $query->getResult();

        return (int)$n[0][1];   
    }
    
    public function getPostsOfFolloweds($page, $articlesPerPage)
    {
        $em = $this->entityManager;
        
        $offset= $page * $articlesPerPage;
        $query = $em->createQuery(
                'SELECT p
                FROM ShopManagementBundle:Post p               
                WHERE p.user = :user_id
                AND p.postStatus = :ps
                ORDER BY p.postDate DESC'
                
                )->setParameter('ps', 'p')->setParameter('user_id', $shop_id)->setFirstResult($offset)->setMaxResults($articlesPerPage);
                $products = $query->getResult();

        return   $products;   
    }
    
    
    
    public function getPostsOfSpecificCategory($category_id, $page, $articlesPerPage)
    {
        $em = $this->entityManager;
        
        $offset= $page * $articlesPerPage;
        $query = $em->createQuery(
                'SELECT p FROM ShopManagementBundle:Post p
                 LEFT JOIN p.categories As c
                 WHERE c.id =:category_id
                 AND p.postStatus = :ps')
                    ->setParameter('ps', 'p')
                    ->setParameter('category_id', $category_id)
                    ->setFirstResult($offset)
                    ->setMaxResults($articlesPerPage);
                
        $products = $query->getResult();

        return   $products;   
    }
    
    public function getNumberOfItemsOfSpecificCategory($category_id)
    {
        $em = $this->entityManager;

        $query = $em->createQuery(
                'SELECT COUNT(p) FROM ShopManagementBundle:Post p
                 LEFT JOIN p.categories As c
                 WHERE c.id =:category_id
                 AND p.postStatus = :ps')
                    ->setParameter('ps', 'p')
                    ->setParameter('category_id', $category_id);
                
        $items = $query->getResult();

        return (int)$items[0][1]; 
    }
    
    public function setLastDate($shop_id, $current_user_id)
    {
        $does=$this->followManager->doesAUserFollowAUser($current_user_id, $shop_id); 
        
        if($does)
        {
            $em = $this->entityManager;
            $follow=$this->followManager->getFollowByFollowerAndFollowed($shop_id,$current_user_id);     

            if (!$follow) {
                throw $this->createNotFoundException('Unable to find Follow entity.');
            }

            $lastDate=new \DateTime();;
            $follow->setLastDate($lastDate);

            $em->persist($follow);
            $em->flush();
        }
    }
    
    public function setFollowSeen($follower_id, $current_user_id)
    {

        $em = $this->entityManager;
        $follow=$this->followManager->getFollowByFollowerAndFollowed($current_user_id,$follower_id);   

        if (!$follow) {
                throw $this->createNotFoundException('Unable to find Follow entity.');
        }

        $follow->setFollowSeen(true);

        $em->persist($follow);
        $em->flush();
           
    }

}
?>
