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

            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $firstPart = array(
                'user' => $me,
                'entities' =>  $this->get('my_shop_controller')->getPostsOfSpecificShop($me->getId(),$page,$articlesPerPage),
                'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfArticles($me->getId())/$articlesPerPage),
                'total_number_of_items'=> $this->get('my_shop_controller')->getNumberOfArticles($me->getId()),
                'page' => $page,
                'categories' => $categories
            );
            

            return $this->render('MobileManagementBundle:Shop:mobileMyShopFull.html.twig',$firstPart);
            }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
    }
}
