<?php

namespace Mobile\Bundle\ManagementBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Shop\Bundle\ManagementBundle\Entity\Post;


class MobileMyMarketController extends Controller
{   
    public function displayMobileMyMarketAction(Request $request, $page)
    {
        $me = $this->getUser();
        if($me)
        {
            $articlesPerPage = 10;
           
            $numberOfFollowedsByCurrentUser =$this->get('members_management.follow.services')->getNumberOfFollowedsByCurrentUser($me);
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $messages= $this->get('shop_management.my_market.services')->getLatestPostsByFolloweds($me->getId());
            
            $numberOfMyMarketMessages = count($messages);
            
            $firstPart = array(
               'number_of_pages'=> ceil($numberOfMyMarketMessages/$articlesPerPage),
               'articles_per_page' => $articlesPerPage,
               'page' => $page,
               'number_of_followeds_by_current_user' => $numberOfFollowedsByCurrentUser,
               'total_number_of_items'=> $numberOfMyMarketMessages,
               'categories' => $categories,
               'messages' => $messages
            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($me->getId());
            
            $finalArray= array_merge( $firstPart, $secondPart);
            
            return $this->render('MobileManagementBundle:MyMarket:mobileMyMarketFull.html.twig', $finalArray );
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
    }
    
    
    
}

?>
