<?php

namespace Shop\Bundle\ManagementBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Shop\Bundle\ManagementBundle\Entity\Category
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parent
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\Shop\Bundle\ManagementBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Shop\Bundle\ManagementBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }


    /**
     * @var boolean
     */
    private $hasChildren;


    /**
     * Set hasChildren
     *
     * @param boolean $hasChildren
     *
     * @return Category
     */
    public function setHasChildren($hasChildren)
    {
        $this->hasChildren = $hasChildren;

        return $this;
    }

    /**
     * Get hasChildren
     *
     * @return boolean
     */
    public function getHasChildren()
    {
        return $this->hasChildren;
    }

    /**
     * Add post
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Post $post
     *
     * @return Category
     */
    public function addPost(\Shop\Bundle\ManagementBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Post $post
     */
    public function removePost(\Shop\Bundle\ManagementBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
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
    
    
    
     public function __toString()
    {
    	return (string)$this->getName();
    }
}
