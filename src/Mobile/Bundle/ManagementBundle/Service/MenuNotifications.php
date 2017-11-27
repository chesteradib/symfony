<?php

namespace Mobile\Bundle\ManagementBundle\Service;
 
 
class MenuNotifications{

    protected $messagesManager;
    protected $followeManager;
    protected $myMarketManager;

    public function __construct($messagesManager, $followeManager, $myMarketManager) 
    {
        $this->messagesManager= $messagesManager;
        $this->followManager= $followeManager;
        $this->myMarketManager= $myMarketManager;
    }
    
    
    public function getMobileMenuNotifications($userId)
    {
        $numberOfMessagesNotSeen= $this->messagesManager->getNumberOfMessagesNotSeenByReceiver($userId);

        $numberOfFollowsNotSeen= $this->followManager->getNumberOfFollowsNotSeenByFollowed($userId);

        /* This is a temporary solution because it uses a big SQL Query of another place to just count some value*/
        $messages= $this->myMarketManager->getLatestPostsByFolloweds($userId);

        $sumArray=0;
        foreach ($messages as $k=>$subArray) 
        {
            $sumArray+=(int)$subArray['countF'];
        }
        
        $result= array(
            'number_of_messages_not_seen' => $numberOfMessagesNotSeen,
            'number_of_follows_not_seen' => $numberOfFollowsNotSeen,
            'number_of_new_posts_by_followeds_not_seen' => $sumArray
        );
        return $result;    
    }
}

