<?php

namespace Members\Bundle\ManagementBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

use Members\Bundle\ManagementBundle\Entity\ProfilePhoto;



class ProfileController extends Controller
{
    const defaultURL= '/pp/index.png';
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        //var_dump($profile_url);die;

        return $this->render('MembersManagementBundle:Profile:show.html.twig', array(
            'user' => $user

        ));
    }
    public function deleteProfilePictureAction(Request $request)
    {
        if ($request->isMethod('POST') && $request->isXmlHttpRequest()) {
            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }

            // needs to remove the file from filesytem to avoid unecessary profile pictures
            $profilePhoto = $user->getProfilePicture();
            $user->setProfilePicture(null);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->remove($profilePhoto);
            $em->flush();

            return new Response(self::defaultURL);
        }
        else
            return new Response('Not  HTML XML Request');
    }

    /**
     *
     *
     */
    public function updateProfilePictureAction(Request $request) {

        if ($request->isMethod('POST') && $request->isXmlHttpRequest()) {

            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }

            $image_file = $request->files->get('fos_user_profile_form')['profile_picture'];
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

            if(!$user->getProfilePicture())
            {
                $image= new ProfilePhoto();
            }
            else
            {
                $image = $user->getProfilePicture();
            }

            $image->setFile($image_file);
            $validator = $this->get('validator');
            $errors = $validator->validate($image);
            if (count($errors) > 0) {
                //print errors from $errors
                return new Response('There is an error either in mimetype, size, or image sizes');
            } else {
                $image->setSubDir('prpf');

                $path =$image->upload();

                $image->setUser($user);
                $image->setWidthVsHeight($widthVsHeight);
                $user->setProfilePicture($image);
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->persist($user);
                $em->flush();
                $uploadedURL= '/uploads/profilepictures/prpf/'. $path;
                return new Response($uploadedURL);

            }
        }
        else
            return new Response('Not  HTML XML Request');
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



    public function renameAfterFilter($imageContent,$imagePath)
    {
        $this->getFileSystem()->write($imagePath, $imageContent);


    }

    /**
     * Getting the filesystem
     *
     * @return boolean
     */
    protected function getFileSystem()
    {
        return $this->get('knp_gaufrette.filesystem_map')->get('image_storage_filesystem');
    }
}