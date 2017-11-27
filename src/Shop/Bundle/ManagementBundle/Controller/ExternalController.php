<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use FOS\UserBundle\Model\UserInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ExternalController extends Controller {

    public function showShopAction($shop_id)
    {
        
        
        $userManager = $this->get('fos_user.user_manager');
       
        $user=$userManager->findUserByUsername('imad');
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }


        return $this->render('ShopManagementBundle:External:External.html.twig', array(
            'shop_id' => $shop_id,
            'user' => $user,
            'entities' => $this->get('my_shop_controller')->getPostsOfSpecificShop(0, $shop_id)
        ));

    }
    

}

?>
