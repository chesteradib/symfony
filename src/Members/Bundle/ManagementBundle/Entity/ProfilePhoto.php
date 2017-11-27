<?php

namespace Members\Bundle\ManagementBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Shop\Bundle\ManagementBundle\Entity\UploadFileMover;

/**
 * ProfilePhoto
 */
class ProfilePhoto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * Image file
     *
     * @var File
     * @Assert\Image(minWidth="138", minHeight="96")
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    private $file;
    
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $subDir;

    /**
     * @var \Members\Bundle\ManagementBundle\Entity\User
     */
    private $user;


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
    $this->path = $uploadFileMover->moveUploadedFile($this->file, self::getUploadDir(),$this->subDir);
   //die(var_dump($this->path));
    // set the path property to the filename where you've saved the file
   // $this->path = $this->getFile()->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
}
    /**
     * Set path
     *
     * @param string $path
     * @return ProfilePhoto
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
     * Set subDir
     *
     * @param string $subDir
     * @return ProfilePhoto
     */
    public function setSubDir($subDir)
    {
        $this->subDir = $subDir;
    
        return $this;
    }

    /**
     * Get subDir
     *
     * @return string 
     */
    public function getSubDir()
    {
        return $this->subDir;
    }

    /**
     * Set user
     *
     * @param \Members\Bundle\ManagementBundle\Entity\User $user
     * @return ProfilePhoto
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
    
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /*
     * 
     */
    protected static $uploadDirectory = 'uploads/profilepictures';
    
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
        $file = $this->getWebPath();
        if ($file) {
            unlink($file);
        }
    }


    /**
     * @var integer
     */
    private $widthVsHeight;


    /**
     * Set widthVsHeight
     *
     * @param integer $widthVsHeight
     * @return ProfilePhoto
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
}
