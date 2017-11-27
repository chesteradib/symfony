<?php

namespace Shop\ManagementBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;


class PostHandler implements PostHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    
    
    
    public function __construct(ObjectManager $om, $entityClass)
    {
        
        $this->om= $om;
        $this->entityClass= $entityClass;
        $this->repository= $this->om->getRepository($entityClass);
        
    }
    
    public function get($id)
    {
        return $this->repository->find($id);

    }
   
}

