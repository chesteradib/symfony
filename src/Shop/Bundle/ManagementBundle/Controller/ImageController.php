<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Shop\Bundle\ManagementBundle\Entity\UploadFileMover;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\Bundle\ManagementBundle\Entity\Image;
use Symfony\Component\Validator\ConstraintViolationList;

//use Symfony\Component\HttpFoundation\File\UploadedFile;
// this use statement is to be user to check if file is instance of Uploaded file and that it got no errors (before the validation)
use Symfony\Component\HttpFoundation\Response;

/**
 * Image controller.
 *
 */
class ImageController extends Controller {

    public function deletesAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            
            $img_id= (int)$request->request->get('image_id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ShopManagementBundle:Image')->find($img_id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Iamge entity.');
            }
           
            $em->remove($entity);
            $em->flush();
            $entity->removeUpload();// can throw error of unlink file doesn't exist
        return new Response('ok');
        }
    }
    
    
    public function uploadsAction(Request $request) {
        
        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            $output='';
            $error='';

            $index=(int)$request->request->get('index');

            $image_file = $request->files->get('shop_bundle_managementbundle_posttype')['images'][$index]['file'];
            
            // here I need to validate image_file for getimagesize warning
            /*
            if(isset($_POST["submit"]) && isset($_FILES['file'])) {
                $file_temp = $_FILES['file']['tmp_name'];   
                $info = getimagesize($file_temp);
            } 
            elseif(isset($_POST["submit"]) && !isset($_FILES['file'])) {
                print "Form was submitted but file wasn't send";
                exit;
            }
            else {
                print "Form wasn't submitted!";
                exit;
            } 
            */
            
            
            $em = $this->getDoctrine()->getManager();

            $main= false;

            $image= new Image();

            list($width, $height) = getimagesize($image_file);

            if($width>$height) 
            { 
                $widthVsHeight=1;
            } 
            else if($width==$height) 
            {
                $widthVsHeight=0;
            }
            else
            { 
                $widthVsHeight=2;
            } 

            $image->setFile($image_file);
            $date= new \DateTime();
            $image->setUploadDate($date);
            $image->setWidthVsHeight($widthVsHeight);

            $validator = $this->get('validator');
            $errors = $validator->validate($image);
            
            if (count($errors) > 0) {
            $error=$errors[0]->getMessage();

                $json= json_encode(array(
                    'code' => false,
                    'error_message' => $error,
                    'output' => '',
                    'image_id'=>'',
                    'index'=>'',
                    'widthVsHeight' => '',
                    'main'=> '',
                    'uploadedURL' => ''
                ));
            } 
            else{
                
                $year= $date->format('Y');
                $month= $date->format('m');
                $day= $date->format('d');
                $hour= $date->format('H');
                
                $subDirString= $year. DIRECTORY_SEPARATOR .$month. DIRECTORY_SEPARATOR .$day. DIRECTORY_SEPARATOR .$hour;
                $renamed= $image->upload();
                $small_path= $subDirString. DIRECTORY_SEPARATOR .'s_'.$renamed;
                $medium_path= $subDirString. DIRECTORY_SEPARATOR .'m_'.$renamed;
                $big_path= $subDirString. DIRECTORY_SEPARATOR .'b_'.$renamed;

                $em->persist($image);
                $em->flush();

                $filter = 'my_filter';
                $heighten_small= array( 'heighten' => 66) ;
                $heighten_medium= array( 'heighten' => 245) ;
                $heighten_big= array( 'heighten' => 960) ;
                $widen_small= array( 'widen' => 62) ;
                $widen_medium= array( 'widen' => 395) ;
                $widen_big= array( 'widen' => 960) ;
                
                $path = $image->getTheWebPath();
                
                $container = $this->container;                                 
                $dataManager = $container->get('liip_imagine.data.manager');
                $filterManager = $container->get('liip_imagine.filter.manager');

                $binary = $dataManager->find($filter, $path);
                    
                if($width>=$height) 
                {          
                    $sBinary =  $filterManager->applyFilter( $binary, $filter, array(
                       'filters' => array(
                           'relative_resize' =>  $widen_small
                        )
                    ));
                    
                    $s = $sBinary->getContent();                               

                    $this->renameAfterFilter($s,'uploads/'.$small_path);
                    
                    $mBinary = $filterManager->applyFilter($binary, $filter, array(
                       'filters' => array(
                           'relative_resize' =>  $widen_medium
                        )
                    ));
                    
                    $m = $mBinary->getContent();                             

                    $this->renameAfterFilter($m,'uploads/'.$medium_path);

                    if($width>960){
                        $bBinary = $filterManager->applyFilter($binary, $filter, array(
                           'filters' => array(
                               'relative_resize' =>  $widen_big
                            )
                        ));
                        
                    }
                    else
                    {
                        $bBinary = $filterManager->applyFilter($binary, $filter, array(
                            'filters' => array(
                                'relative_resize' =>  array( 'widen' => $width)
                             )
                         ));
                    }
                    
                    $b = $bBinary->getContent();                              
                    $this->renameAfterFilter($b,'uploads/'.$big_path);
                } 
                else
                { 
                    $sBinary =  $filterManager->applyFilter( $binary, $filter, array(
                       'filters' => array(
                           'relative_resize' =>  $heighten_small
                        )
                    ));

                    $s = $sBinary->getContent();                               

                    $this->renameAfterFilter($s,'uploads/'.$small_path);
                    
                    $mBinary = $filterManager->applyFilter($binary, $filter, array(
                       'filters' => array(
                           'relative_resize' =>  $heighten_medium
                        )
                    ));
                    
                    $m = $mBinary->getContent();                             

                    $this->renameAfterFilter($m,'uploads/'.$medium_path);
                    
                    if($height<=960){
                        $heighten_big= array( 'heighten' => $height) ;
                    }
                    
                    $bBinary = $filterManager->applyFilter($binary, $filter, array(
                       'filters' => array(
                           'relative_resize' =>  $heighten_big
                        )
                    ));
                    
                    $b = $bBinary->getContent();                              

                    $this->renameAfterFilter($b,'uploads/'.$big_path);
                } 
                unlink($path);
                $spath2 = str_replace("uploads","",$small_path );

                $json= json_encode(array(
                    'code' => true,
                    'error_message' => '',
                    'output' => $output,
                    'image_id'=>$image->getId(),
                    'index'=>$index,
                    'widthVsHeight' => $widthVsHeight,
                    'main'=> $main,
                    'uploadedURL' => $spath2
                ));
            }
            
            $response = new Response($json);
            $response->headers->set('Content-Type', 'application/json');
            return $response; 
        }
        else
        {
            return new Response('It is not an XML HTTP Request');
            
        }
    } 
        
    public function renameAfterFilter($imageContent,$imagePath)
    {
        $f = fopen($imagePath, 'w');                                 
        fwrite($f, $imageContent );                                            
        fclose($f);
        
    }
    
    
    
    
}