<?php

namespace Members\Bundle\ManagementBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    public function findByCategories2($categoryId) {
        return $this->getEntityManager()
        ->createQuery(
            "SELECT t, d FROM ShopManagementBundle:Post t
                LEFT JOIN t.categories d
                WHERE
                  d.id = :compte_id"
        )
        ->setParameter('compte_id', $categoryId)
        ->getResult();

        
    }
 public function findByCategories($categoryId) {
        
     
        $qb = $this->createQueryBuilder('a');
        $qb->add('select', 'a');
        $qb->leftJoin('a.categories', 'c');
        $qb->where('c.id LIKE :category'); /* i have guessed a.name */
        $qb->setParameter('category', $categoryId);
        $qb->getQuery()->getResult();
     
     /*
             $em = $this->entityManager;
        
        $query = $em->createQuery(
                'SELECT SELECT j, t
                FROM ShopManagementBundle:Post j 
                LEFT JOIN j.categories t
                WHERE ?0 MEMBER OF j.categories
                '
                
                )->setParameter('0', $categories);
        $images = $query->getResult();*/
        
        //var_dump($images);
      
    }
    
    
    }
