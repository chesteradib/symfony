<?php

namespace Members\Bundle\ManagementBundle\Controller;


use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Response;
use Members\Bundle\ManagementBundle\Entity\ProfilePhoto;
use Members\Bundle\ManagementBundle\Entity\User;

class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        static $uploadDirectory = 'uploads/profilepictures';
        static $default='default_profile.jpg';
        
        
        if($user->getProfilePicture())
        {
            $profile_url=$uploadDirectory. DIRECTORY_SEPARATOR .$user->getProfilePicture()->getPath();
            
        }
            else
            {
                
                $profile_url=$uploadDirectory. DIRECTORY_SEPARATOR .$default;
            }     
        
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'profile_url' => $profile_url
            
        ));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        
        
        $user = $this->getUser();
        //die(var_dump($user->getProfilePicture()));

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();

        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            //$user->setProfilePhoto
            $userManager->updateUser($user);
/*
            if (null === $response = $event->getResponse()) {
                
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
                */
                
                //////// Added code
                        
                return $this->showAction();
                
                
                //// End Added code 
            //}         

            return $response;
        }
        //}
        
        
        static $uploadDirectory = 'uploads/profilepictures';
        static $default='default_profile.jpg';
        
        if($user->getProfilePicture())
        {
            $profile_url=$uploadDirectory. DIRECTORY_SEPARATOR .$user->getProfilePicture()->getPath();  
        }
        else
        {
         $profile_url=$uploadDirectory. DIRECTORY_SEPARATOR .$default;
        }     
   
        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'profile_url' => $profile_url
        ));
        
        
    }
    
    /*
    public function latLngJsonAction()
    {
        
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        //var_dump($user);     
        
        $json= json_encode(array(
       'latitude' => $user->getLatitude(),
       'longitude' => $user->getLongitude()));
        
           $response = new Response($json);
           $response->headers->set('Content-Type', 'application/json');
           return $response; 
           }
    */
    
     public function deleteProfilePictureAction(Request $request, $img_id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MembersManagementBundle:ProfilePhoto')->find($img_id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProfilePhoto entity.');
            }
            $entity->removeUpload();
            $em->remove($entity);
            $em->flush();

            return new Response();
    }
    
    public function updateProfilePictureAction(Request $request, $user_id) {

        if ($request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();        
            
            $user = $em->getRepository('MembersManagementBundle:User')->find($user_id);
            
            if (!$user) {
                throw $this->createNotFoundException('Unable to find user entity.');
            }
            
            
            if(!$user->getProfilePicture())
            {
                        echo "hi";
                        $image= new ProfilePhoto();

                        $image_file = $request->files->get('fos_user_profile_form')['profile_picture'];

                        $image->setFile($image_file);

                        $validator = $this->get('validator');
                        $errors = $validator->validate($image);
                        if (count($errors) > 0) {
                                    //print errors from $errors
                                    return new Response('There is an error either in mimetype, size, or image sizes');
                        } else {

                        $image->setSubDir('prpf');
                        $image->upload();

                        $image->setUser($user);

                        $user->setProfilePicture($image);

                            $em->persist($image);
                            $em->persist($user);
                            $em->flush();  
                            $the_id=$image->getId();



                        $uploadedURL= $image->getUploadDir(). DIRECTORY_SEPARATOR . $image->getSubDir(). DIRECTORY_SEPARATOR . $image_file->getBasename();

                        return $this->render('MembersManagementBundle:Profile:image_portion.html.twig', array(
                                        'uploadedURL' => $uploadedURL,
                                        'image_id'=>$the_id,
                                       ));
                                    }
            }
            else
            {
                
                        $image = $em->getRepository('MembersManagementBundle:ProfilePhoto')->findOneBy(array('user' => $user));
                       

                        $image_file = $request->files->get('fos_user_profile_form')['profile_picture'];

                        $image->setFile($image_file);

                        $validator = $this->get('validator');
                        $errors = $validator->validate($image);
                        if (count($errors) > 0) {
                                    //print errors from $errors
                                    return new Response('There is an error either in mimetype, size, or image sizes');
                        } else {

                        $image->setSubDir('prpf');
                        $image->upload();

                        $image->setUser($user);

                        $user->setProfilePicture($image);

  
                        $em->persist($user);
                        $em->flush();  
                        $the_id=$image->getId();

                        $uploadedURL= $image->getUploadDir(). DIRECTORY_SEPARATOR . $image->getSubDir(). DIRECTORY_SEPARATOR . $image_file->getBasename();

                        return $this->render('MembersManagementBundle:Profile:image_portion.html.twig', array(
                                        'uploadedURL' => $uploadedURL,
                                        'image_id'=>$the_id,
                                       ));
                                    }
                
            }
            
            
            
            
        }
        else
            return new Response('Not  HTML XML Request');

            /*
            $existing_profile_picture = $em->getRepository('MembersManagementBundle:ProfilePhoto')->findOneBy(array('user' => $user));
            
            if (!$existing_profile_picture) {
                
                $user->setProfilePicture($image);
            
                $em->persist($image);
                $em->flush();  
                $the_id=$image->getId();
            }
            else
            {
                $user->setProfilePicture($image);
                $the_id=$existing_profile_picture->getId();
                die(var_dump($existing_profile_picture));
            }*/
    } 
    
    /**
     * Deactivate profile
     */
    
    public function deactivateProfileAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user->setEnabled(false);
        return new Response($this->generateUrl('fos_user_security_logout'));
            
    }
    

}
