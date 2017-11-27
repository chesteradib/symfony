<?php

namespace RealTime;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class RealTimePusher implements WampServerInterface{
    
    
    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();
    
    public function onSubscribe(ConnectionInterface $conn, $topic) {
        echo "Subscription! ({$conn->resourceId})\n";
        //var_dump($topic);
        $this->subscribedTopics[$topic->getId()] = $topic;
        
    }
    public function onUnSubscribe(ConnectionInterface $conn, $topic) {
    }
    public function onOpen(ConnectionInterface $conn) {
        
        echo "New connection! ({$conn->resourceId})\n";
    }
    public function onClose(ConnectionInterface $conn) {
        
         echo "connection Closed! ({$conn->resourceId})\n";
    }
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
       
    }
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
    
    
    public function onRealTime($entry)
    {
        $decodedEntry= json_decode($entry,true);

        switch($decodedEntry['type'])
        {
            case 'my_inbox':
                
                if (array_key_exists($decodedEntry['receiver_id'], $this->subscribedTopics)) {
                        $topic = $this->subscribedTopics[$decodedEntry['receiver_id']];
                        unset($decodedEntry['receiver_id']);
                        $topic->broadcast($decodedEntry);
                }
                break;
            case 'my_followers':
                if (array_key_exists($decodedEntry['followed_id'], $this->subscribedTopics)) {
                        $topic = $this->subscribedTopics[$decodedEntry['followed_id']];
                        unset($decodedEntry['followed_id']);
                        $topic->broadcast($decodedEntry);
                }
                break;
            case 'my_market':
                $temp= $decodedEntry;
                unset($decodedEntry['followers']);
                for ($i = 0; $i < count($temp['followers']); ++$i) {
                 if (array_key_exists($temp['followers'][$i], $this->subscribedTopics)) {
                        $topic = $this->subscribedTopics[$temp['followers'][$i]];
                        $topic->broadcast($decodedEntry);
                    }
                }
                break;
            default:
                echo 'no_one and not possible';
        }
         
    }

}