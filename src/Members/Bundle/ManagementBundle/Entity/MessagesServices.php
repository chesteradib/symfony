<?php

namespace Members\Bundle\ManagementBundle\Entity;
 
use Doctrine\ORM\Query\ResultSetMapping;


class MessagesServices {

    protected $entityManager;
    protected $repository;
    protected $entityClass;

    public function __construct($entityManager, $entityClass ) {
        $this->entityManager = $entityManager;
        $this->entityClass= $entityClass;
        $this->repository= $this->entityManager->getRepository($this->entityClass);
    }
    
    public function getLatestMessagesForInboxReceivedBy($receiver_id)
    {
            $em= $this->entityManager;
           
            $rsm = new ResultSetMapping();
            
            $rsm->addEntityResult('MembersManagementBundle:Message', 'm');
            $rsm->addFieldResult('m', 'id', 'id');
            $rsm->addFieldResult('m', 'message_date', 'messageDate');
            $rsm->addMetaResult('m', 'post_owner_id', 'post_owner_id'); 
            $rsm->addMetaResult('m', 'sender_id', 'sender_id');
            $rsm->addMetaResult('m', 'receiver_id', 'receiver_id'); 
            $rsm->addMetaResult('m', 'post_id', 'post_id');
            $rsm->addScalarResult('result', 'result');

            $query = $em->createNativeQuery('SELECT m.*, s.rs as result
                FROM  message AS m
                INNER JOIN (SELECT id, sender_id, MAX(message_date) as md FROM message WHERE message_seen=0 and  receiver_id =? GROUP BY post_id,sender_id) AS t
                INNER JOIN (SELECT id, sender_id, COUNT(message_seen) as rs FROM message WHERE message_seen=0 and receiver_id=? GROUP BY  post_id, sender_id) AS s
                ON m.message_date=t.md and t.id=s.id
                WHERE receiver_id =?
                GROUP BY post_id, sender_id
                ORDER BY message_date DESC', $rsm);
            $query->setParameter(1, $receiver_id)
            ->setParameter(2, $receiver_id)
            ->setParameter(3, $receiver_id);

            $n= $query->getResult();

            return $n;
}
    
  
    public function getNumberOfMessagesNotSeenByReceiver($receiver_id)
    {
            $em = $this->entityManager;
            
            $query = $em->createQuery(
                'SELECT count(m)
                FROM MembersManagementBundle:Message m               
                WHERE m.messageSeen =:seen
                AND m.receiver =:receiverId'
                )->setParameters(array (
                'receiverId' => $receiver_id,
                'seen' => 0
            ));
            $n = $query->getResult();
        return (int)$n[0][1]; 
    }
    
    public function getMessagesNotSeenByMeForSpecificPostAndSender($sender_id,$receiver_id, $post_id)
    {
           $em= $this->entityManager;
           
           $query = $em->createQuery(
                'SELECT m
                FROM MembersManagementBundle:Message m            
                WHERE m.messageSeen =:seen
                AND m.sender =:senderId
                AND m.receiver =:receiverId
                AND m.post =:postId
                '
            )->setParameters(array (
                'receiverId' => $receiver_id,
                'seen' => 0,
                'postId' => $post_id,
                'senderId' => $sender_id
            ));
                   
           $n= $query->getResult();
           
           return $n;
    }
    public function getMessagesBetweenTwoUsersAboutArticle($sender_id,$receiver_id, $post_id)
    {
           $em= $this->entityManager;
           
           $query = $em->createQuery(
                'SELECT m
                FROM MembersManagementBundle:Message m            
                WHERE ( m.sender =:senderId and m.receiver=:receiverId and m.post =:postId  )
                OR( m.sender =:receiverId and m.receiver =:senderId and m.post =:postId  )
                ORDER BY m.messageDate ASC'
                )->setParameters(array(
                    'receiverId' => $receiver_id,
                    'senderId' => $sender_id,
                    'postId' => $post_id
                ));
                   
           $n= $query->getResult();
           
           return $n;
    }
    public function getAllMyMessages($me,$page,$messagesPerPage)
    {
            $em= $this->entityManager;
            
            $offset= $page * $messagesPerPage;
            $rsm = new ResultSetMapping();
            
            $rsm->addEntityResult('MembersManagementBundle:Message', 'm');
            $rsm->addFieldResult('m', 'id', 'id');
            $rsm->addFieldResult('m', 'message_date', 'messageDate');
            $rsm->addMetaResult('m', 'sender_id', 'sender_id');
            $rsm->addMetaResult('m', 'receiver_id', 'receiver_id');
            $rsm->addMetaResult('m', 'post_owner_id', 'post_owner_id'); 
            $rsm->addMetaResult('m', 'post_id', 'post_id');
            $rsm->addMetaResult('m', 'message_content', 'messageContent');
            $rsm->addMetaResult('m', 'message_seen', 'messageSeen');
            
           

            $query = $em->createNativeQuery('SELECT m.*
                    FROM  message AS m
                    INNER JOIN (SELECT id, MAX(message_date) as md FROM message WHERE receiver_id =? OR sender_id=? group by post_id) AS t
                    ON m.message_date=t.md
                    WHERE receiver_id =? OR sender_id=?
                    order by message_date DESC
                    LIMIT ? OFFSET ?', $rsm);
            $query->setParameter(1, $me)
                    ->setParameter(2, $me)
                    ->setParameter(3, $me)
                    ->setParameter(4, $me)
                    ->setParameter(5,$messagesPerPage )
                    ->setParameter(6, $offset);
            $n= $query->getResult();

            return $n;
    }
    
    public function getNumberOfAllMyMessages($me)
    {
            $em= $this->entityManager;
            
            $rsm = new ResultSetMapping();
            
            $rsm->addEntityResult('MembersManagementBundle:Message', 'm');
            $rsm->addFieldResult('m', 'id', 'id');
            $rsm->addFieldResult('m', 'message_date', 'messageDate');
            $rsm->addMetaResult('m', 'sender_id', 'sender_id');
            $rsm->addMetaResult('m', 'receiver_id', 'receiver_id');
            $rsm->addMetaResult('m', 'post_owner_id', 'post_owner_id'); 
            $rsm->addMetaResult('m', 'post_id', 'post_id');
            $rsm->addMetaResult('m', 'message_content', 'messageContent');
            $rsm->addMetaResult('m', 'message_seen', 'messageSeen');
            
           

            $query = $em->createNativeQuery('SELECT m.*
                    FROM  message AS m
                    INNER JOIN (SELECT id, MAX(message_date) as md FROM message WHERE receiver_id =? OR sender_id=? group by post_id) AS t
                    ON m.message_date=t.md
                    WHERE receiver_id =? OR sender_id=?
                    order by message_date DESC', $rsm);
            $query->setParameter(1, $me)
                    ->setParameter(2, $me)
                    ->setParameter(3, $me)
                    ->setParameter(4, $me);
            $n= $query->getResult();
            
            return count($n); 
    }
    

  
}
?>
