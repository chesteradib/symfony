<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class MobileProfileController extends Controller
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

        //var_dump($profile_url);die;

        return $this->render('MobileManagementBundle:Profile:show.html.twig', array(
            'user' => $user

        ));
    }

}