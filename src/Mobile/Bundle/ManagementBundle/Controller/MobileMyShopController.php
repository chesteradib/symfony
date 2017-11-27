<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MobileMyShopController extends Controller
{
     public function displayMobileMyShopAction(Request $request, $page)
    {
        $me = $this->getUser();
        if($me)
        {
            $articlesPerPage = 10;

            $numberOfFollowersOfUser= $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($me->getId());

            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $firstPart = array(
                'user' => $me,
                'number_of_followers_of_user' => $numberOfFollowersOfUser,
                'entities' =>  $this->get('my_shop_controller')->getPostsOfSpecificShop($me->getId(),$page,$articlesPerPage),
                'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfArticles($me->getId())/$articlesPerPage),
                'total_number_of_items'=> $this->get('my_shop_controller')->getNumberOfArticles($me->getId()),
                'page' => $page,
                'categories' => $categories
            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($me->getId());
            
            $finalArray= array_merge($firstPart, $secondPart);
            
            return $this->render('MobileManagementBundle:Shop:mobileMyShopFull.html.twig',$finalArray );   
            }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
    }
}
