<?php

namespace Shop\Bundle\ManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Post
 */
class Post
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $postDate;

    /**
    * @var string

    * @Assert\NotBlank(
    *      message = "post.description.not_blank" 
    * )     
    * @Assert\Length(
    *      min = "20",
    *      max = "500",
    *      minMessage = "post.description.length.min",
    *      maxMessage = "post.description.length.max"    
    * )     
    */
    private $postContent;

    /**
    * @var string

    * @Assert\NotBlank(
    *      message = "post.title.not_blank" 
    * )     
    * @Assert\Length(
    *      min = "10",
    *      max = "80",
    *      minMessage = "post.title.length.min",
    *      maxMessage = "post.title.length.max"    
    * )     
    */
    private $postTitle;

    /**
     * @var boolean
     */
    private $bought;

    /**
    * @var integer

    * @Assert\NotBlank(
    *      message = "post.price.not_blank" 
    * )
    * @Assert\Type(
    *     type="numeric",
    *     message="post.price.type"
     * )  
    * @Assert\Length(
    *      max = "10",
    *      minMessage = "post.price.length" 
    * )     
    * @Assert\GreaterThanOrEqual(
    *     value = 0,
    *     message = "post.price.greater_than_or_equal"
    * )
    */
    
    private $postPrice;

    /**
     * @var string
     */
    private $postMainImagePath;

    /**
     * @var string
     */
    private $postStatus;


    /**
     * @var \Members\Bundle\ManagementBundle\Entity\User
     */
    private $user;

    /**
    * @var \Doctrine\Common\Collections\Collection
     
    * @Assert\Count(
    *      min = "1",
    *      minMessage = "post.images.count.min",
    *      max = "8",
    *      maxMessage = "post.images.count.max",
    * )
    */
    private $images;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Assert\NotBlank(
     *      message = "post.categories.not_blank" 
     * )
     *
     * @Assert\NotNull(
     *      message = "post.categories.not_blank"
     * )
     */
    private $categories;
    
    /**
    * @var string    
    * @Assert\Length(
    *      max = "250",
    *      maxMessage = "post.notes.length.max"    
    * )     
    */
    private $postNotes;
    
    /**
     * Constructor
     */
    
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return Post
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
    
        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime 
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set postContent
     *
     * @param string $postContent
     * @return Post
     */
    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;
    
        return $this;
    }

    /**
     * Get postContent
     *
     * @return string 
     */
    public function getPostContent()
    {
        return $this->postContent;
    }

    /**
     * Set postTitle
     *
     * @param string $postTitle
     * @return Post
     */
    public function setPostTitle($postTitle)
    {
        $this->postTitle = $postTitle;
    
        return $this;
    }

    /**
     * Get postTitle
     *
     * @return string 
     */
    public function getPostTitle()
    {
        return $this->postTitle;
    }

    /**
     * Set bought
     *
     * @param boolean $bought
     * @return Post
     */
    public function setBought($bought)
    {
        $this->bought = $bought;
    
        return $this;
    }

    /**
     * Get bought
     *
     * @return boolean 
     */
    public function getBought()
    {
        return $this->bought;
    }

    /**
     * Set postPrice
     *
     * @param integer $postPrice
     * @return Post
     */
    public function setPostPrice($postPrice)
    {
        $this->postPrice = $postPrice;
    
        return $this;
    }

    /**
     * Get postPrice
     *
     * @return integer 
     */
    public function getPostPrice()
    {
        return $this->postPrice;
    }

    /**
     * Set postMainImagePath
     *
     * @param string $postMainImagePath
     * @return Post
     */
    public function setPostMainImagePath($postMainImagePath)
    {
        $this->postMainImagePath = $postMainImagePath;
    
        return $this;
    }

    /**
     * Get postMainImagePath
     *
     * @return string 
     */
    public function getPostMainImagePath()
    {
        return $this->postMainImagePath;
    }

    /**
     * Set postStatus
     *
     * @param string $postStatus
     * @return Post
     */
    public function setPostStatus($postStatus)
    {
        $this->postStatus = $postStatus;
    
        return $this;
    }

    /**
     * Get postStatus
     *
     * @return string 
     */
    public function getPostStatus()
    {
        return $this->postStatus;
    }


    /**
     * Set user
     *
     * @param \Members\Bundle\ManagementBundle\Entity\User $user
     * @return Post
     */
    public function setUser(\Members\Bundle\ManagementBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Members\Bundle\ManagementBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add images
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Image $images
     * @return Post
     */
    public function addImage(\Shop\Bundle\ManagementBundle\Entity\Image $images)
    {
        $this->images[] = $images;
        $images->setPost($this);
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Image $images
     */
    public function removeImage(\Shop\Bundle\ManagementBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }


    /**
     * Add category
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Category $category
     *
     * @return Post
     */
    public function addCategory(\Shop\Bundle\ManagementBundle\Entity\Category $category)
    {
        $this->categories[] = $category;
        //$category->addPost($this);
        return $this;
    }

    /**
     * Remove category
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Category $category
     */
    public function removeCategory(\Shop\Bundle\ManagementBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
    

    /**
     * Set postNotes
     *
     * @param string $postNotes
     *
     * @return Post
     */
    public function setPostNotes($postNotes)
    {
        $this->postNotes = $postNotes;

        return $this;
    }

    /**
     * Get postNotes
     *
     * @return string
     */
    public function getPostNotes()
    {
        return $this->postNotes;
    }
    /**
     * @var \Shop\Bundle\ManagementBundle\Entity\Place
     */
    private $postPlace;


    /**
     * Set postPlace
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Place $postPlace
     *
     * @return Post
     */
    public function setPostPlace(\Shop\Bundle\ManagementBundle\Entity\Place $postPlace = null)
    {
        $this->postPlace = $postPlace;

        return $this;
    }

    /**
     * Get postPlace
     *
     * @return \Shop\Bundle\ManagementBundle\Entity\Place
     */
    public function getPostPlace()
    {
        return $this->postPlace;
    }
}
