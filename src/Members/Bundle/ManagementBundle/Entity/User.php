<?php
namespace Members\Bundle\ManagementBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 */
class User extends BaseUser
{
    
    protected $id;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @var string
     */
    private $domain_name;


    private $latitude;


    private $longitude;

    /**
     * @var string
     */
    private $store_description;

    /**
     * @var string
     */
    private $phone_number;



    /**
     * Set domain_name
     *
     * @param string $domainName
     * @return User
     */
    public function setDomainName($domainName)
    {
        $this->domain_name = $domainName;
    
        return $this;
    }

    /**
     * Get domain_name
     *
     * @return string 
     */
    public function getDomainName()
    {
        return $this->domain_name;
    }


    /**
     * Set latitude
     *
     * @param float $latitude
     * @return User
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return User
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set store_description
     *
     * @param string $storeDescription
     * @return User
     */
    public function setStoreDescription($storeDescription)
    {
        $this->store_description = $storeDescription;
    
        return $this;
    }

    /**
     * Get store_description
     *
     * @return string 
     */
    public function getStoreDescription()
    {
        return $this->store_description;
    }

    /**
     * Set phone_number
     *
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phone_number
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $messages_sent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $messages_received;


    /**
     * Add messages_sent
     *
     * @param \Members\Bundle\ManagementBundle\Entity\Message $messagesSent
     * @return User
     */
    public function addMessagesSent(\Members\Bundle\ManagementBundle\Entity\Message $messagesSent)
    {
        $this->messages_sent[] = $messagesSent;
    
        return $this;
    }

    /**
     * Remove messages_sent
     *
     * @param \Members\Bundle\ManagementBundle\Entity\Message $messagesSent
     */
    public function removeMessagesSent(\Members\Bundle\ManagementBundle\Entity\Message $messagesSent)
    {
        $this->messages_sent->removeElement($messagesSent);
    }

    /**
     * Get messages_sent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessagesSent()
    {
        return $this->messages_sent;
    }

    /**
     * Add messages_received
     *
     * @param \Members\Bundle\ManagementBundle\Entity\Message $messagesReceived
     * @return User
     */
    public function addMessagesReceived(\Members\Bundle\ManagementBundle\Entity\Message $messagesReceived)
    {
        $this->messages_received[] = $messagesReceived;
    
        return $this;
    }

    /**
     * Remove messages_received
     *
     * @param \Members\Bundle\ManagementBundle\Entity\Message $messagesReceived
     */
    public function removeMessagesReceived(\Members\Bundle\ManagementBundle\Entity\Message $messagesReceived)
    {
        $this->messages_received->removeElement($messagesReceived);
    }

    /**
     * Get messages_received
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessagesReceived()
    {
        return $this->messages_received;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var \Members\Bundle\ManagementBundle\Entity\ProfilePhoto
     */
    private $profile_picture;


    /**
     * Set profile_picture
     *
     * @param \Members\Bundle\ManagementBundle\Entity\ProfilePhoto $profilePicture
     * @return User
     */
    public function setProfilePicture(\Members\Bundle\ManagementBundle\Entity\ProfilePhoto $profilePicture = null)
    {
        $this->profile_picture = $profilePicture;
    
        return $this;
    }

    /**
     * Get profile_picture
     *
     * @return \Members\Bundle\ManagementBundle\Entity\ProfilePhoto 
     */
    public function getProfilePicture()
    {
        return $this->profile_picture;
    }
 
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $followedds;


    /**
     * Add followedds
     *
     * @param \Members\Bundle\ManagementBundle\Entity\Follow $followedds
     * @return User
     */
    public function addFollowedd(\Members\Bundle\ManagementBundle\Entity\Follow $followedds)
    {
        $this->followedds[] = $followedds;
    
        return $this;
    }

    /**
     * Remove followedds
     *
     * @param \Members\Bundle\ManagementBundle\Entity\Follow $followedds
     */
    public function removeFollowedd(\Members\Bundle\ManagementBundle\Entity\Follow $followedds)
    {
        $this->followedds->removeElement($followedds);
    }

    /**
     * Get followedds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollowedds()
    {
        return $this->followedds;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;


    /**
     * Add posts
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Post $posts
     * @return User
     */
    public function addPost(\Shop\Bundle\ManagementBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    
        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Post $posts
     */
    public function removePost(\Shop\Bundle\ManagementBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }
    /**
     * @var \DateTime
     */
    private $createdAt;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
