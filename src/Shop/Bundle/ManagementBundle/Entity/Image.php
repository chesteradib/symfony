<?php

namespace Shop\Bundle\ManagementBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Image
 */
class Image
{

    protected $id;

 /**
     * Image file
     *
     * @var File
     * @Assert\Image(
     *      minWidth="138", 
     *      minHeight="96",
     *      minWidthMessage="The image Width should be greater than 138 pixels.",
     *      minHeightMessage="The image Height should be greater than 96 pixels."
     * )
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    private $file;


    protected $path;

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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to

        $uploadFileMover = new UploadFileMover();
        $this->path = $uploadFileMover->moveUploadedFile($this->file, self::getUploadDir(),$this->getUplaodDateAsDir());

        // set the path property to the filename where you've saved the file
        // clean up the file property as you won't need it anymore

        $this->file = null;
        return $this->path;
    }


    /**
     * @var \TEST\Bundle\BlogBundle\Entity\Post
     */
    private $post;


    /**
     * Set post
     *
     * @param \Shop\Bundle\ManagementBundle\Entity\Post $post
     * @return Image
     */
    public function setPost(\Shop\Bundle\ManagementBundle\Entity\Post $post = null)
    {
        $this->post = $post;
    
        return $this;
    }

    /**
     * Get post
     *
     * @return \Shop\Bundle\ManagementBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    
    public function getUplaodDateAsDir()
    {
        $date= $this->uploadDate;
        $year= $date->format('Y');
        $month= $date->format('m');
        $day= $date->format('d');
        $hour= $date->format('H');

        $subDirString= $year. DIRECTORY_SEPARATOR .$month. DIRECTORY_SEPARATOR .$day. DIRECTORY_SEPARATOR .$hour;
        return $subDirString;
    }
    
    
    public function getTheWebPath()
    {

        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->getUplaodDateAsDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    

    public function getRenamed()
    {
        $uploadFileMover = new UploadFileMover();
        return $uploadFileMover->renameUploadedFile($this->file);
    }

    /*
     * 
     */
    protected static $uploadDirectory = 'uploads';
    
    static public function getUploadDir()
    {
        if (self::$uploadDirectory === null) {
        throw new \RuntimeException("Trying to access upload directory for profile files");
        }
        return self::$uploadDirectory;
    }
    
    static public function setUploadDir($dir)
    {
        self::$uploadDirectory = $dir;
    }
    
     /**
     * 
     *
     * Remove Uploaded Image
     */
    
    public function removeUpload()
    {

        $file = $this->path;

        $year= $this->uploadDate->format('Y');
        $month= $this->uploadDate->format('m');
        $day= $this->uploadDate->format('d');
        $hour= $this->uploadDate->format('H');
                
        $subDirString= $year. DIRECTORY_SEPARATOR .$month. DIRECTORY_SEPARATOR .$day. DIRECTORY_SEPARATOR .$hour;

        $spath= "uploads/".$subDirString. DIRECTORY_SEPARATOR .'s_'.$file;
        $mpath= "uploads/".$subDirString. DIRECTORY_SEPARATOR .'m_'.$file;
        $bpath= "uploads/".$subDirString. DIRECTORY_SEPARATOR .'b_'.$file;
        
        
        if ($file && $spath  && $mpath  && $bpath) {
            unlink($spath);
            unlink($mpath);
            unlink($bpath);
        }
    }


    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * @var integer
     */
    private $widthVsHeight;


    /**
     * Set widthVsHeight
     *
     * @param integer $widthVsHeight
     * @return Image
     */
    public function setWidthVsHeight($widthVsHeight)
    {
        $this->widthVsHeight = $widthVsHeight;
    
        return $this;
    }

    /**
     * Get widthVsHeight
     *
     * @return integer 
     */
    public function getWidthVsHeight()
    {
        return $this->widthVsHeight;
    }
    /**
     * @var \DateTime
     */
    private $uploadDate;


    /**
     * Set uploadDate
     *
     * @param \DateTime $uploadDate
     * @return Image
     */
    public function setUploadDate($uploadDate)
    {
        $this->uploadDate = $uploadDate;
    
        return $this;
    }

    /**
     * Get uploadDate
     *
     * @return \DateTime 
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }
}
