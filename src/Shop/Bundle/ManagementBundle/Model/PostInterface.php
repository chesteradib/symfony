<?php
namespace Shop\Bundle\ManagementBundle\Model;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface PostInterface 

{
    
    public function getId();

    public function setPostDate($postDate);

    public function getPostDate();

    public function setPostContent($postContent);
    

    public function getPostContent();
    
    public function setPostTitle($postTitle);
    
    public function getPostTitle();
    
    public function setCommentStatus($commentStatus);
    
    public function getCommentStatus();
    
    public function getImages();
  
    public function setPostPrice($postPrice);
    
    public function getPostPrice();
    

    public function setPostMainImagePath($postMainImagePath);
    
    public function getPostMainImagePath();

    public function setPostStatus($postStatus);
    
    public function getPostStatus();
    

    public function setBought($bought);
    
    public function getBought();
    

    public function addImage(\Shop\Bundle\ManagementBundle\Entity\Image $images);
    
    public function removeImage(\Shop\Bundle\ManagementBundle\Entity\Image $images);
    

    public function setUser(\Members\Bundle\ManagementBundle\Entity\User $user = null);
    
    public function getUser();
}