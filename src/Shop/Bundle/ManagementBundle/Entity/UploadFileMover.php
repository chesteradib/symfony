<?php
 namespace Shop\Bundle\ManagementBundle\Entity;
 use Symfony\Component\HttpFoundation\File\UploadedFile;

 
class UploadFileMover {
    
    public function renameUploadedFile(UploadedFile $file)
    {
        $image = md5_file($file);
        
        return $image.'.'.$file->guessExtension();
        
        //return md5(mt_rand().$image).'.'.$file->guessExtension();
        
    }
    
    public function moveUploadedFile(UploadedFile $file, $uploadBasePath,$relativePath)
    {
        
        $reNamed = $this->renameUploadedFile($file);
        
        $targetFileName = $relativePath . DIRECTORY_SEPARATOR . $reNamed ;

        $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
        
        $targetDir = $uploadBasePath . DIRECTORY_SEPARATOR . $relativePath;
        
        if (!is_dir($targetDir)) {

        $ret = mkdir($targetDir, 0755, true);
            if (!$ret) {
            throw new \RuntimeException("Could not create target directory to move temporary file into.");
            }
        }
        
        $file->move($targetDir, basename($targetFilePath));

        return $reNamed;
    }
}
?>