<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MyShopController extends Controller
{

    
    public function displayMyShopAction(Request $request)
    {
       
        if($request->isXmlHttpRequest())
        {
            $user= $this->getUser();
            $articlesPerPage = (int)$request->request->get('articles_per_page');

            

            return $this->render('ShopManagementBundle:MyShop:MyShop.html.twig', array(
                'user' => $user,
                'entities' =>  $this->get('my_shop_controller')->getPostsOfSpecificShop($user->getId(),0,$articlesPerPage),
                'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfArticles($user->getId())/$articlesPerPage),
                'total_number_of_items'=> $this->get('my_shop_controller')->getNumberOfArticles($user->getId())
            )); 
        }
        else return new Response('Not XMLHttpRequest');

    }
}
?>
