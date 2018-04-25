<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MobileShopController extends Controller
{
    
    public function displayMobileShopAction($shop_id,$page)
    {
        $user = $this->getUser();
        
        
        $firstPart= array();
        
        if($user)
        {
            if($user->getId()== $shop_id)
            {
                $url = $this->generateUrl("mobile_my_shop", array( 'page' => 0));
                return $this->redirect($url); 
            }
        }
        
        
        $em = $this->getDoctrine()->getManager();

        $userofShopId= $em->getRepository('MembersManagementBundle:User')->find($shop_id);
        $articlesPerPage = 10;

        
        $categories= $this->get('shop_management.category.services')->getAllCategories();
        
        $mainPart = array(
            'user' => $userofShopId,
            'entities' =>  $this->get('my_shop_controller')->getPostsOfSpecificShop($shop_id,$page,$articlesPerPage),
            'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfArticles($shop_id)/$articlesPerPage),
            'total_number_of_items'=> $this->get('my_shop_controller')->getNumberOfArticles($shop_id),
            'page' => $page,
            'categories' => $categories
        );
        
        $finalArray=array_merge($mainPart,$firstPart);
        
        return $this->render('MobileManagementBundle::mobileShop.html.twig', $finalArray); 

    }



    public function displayMobileShopFromMyNetworkAction($shop_id,$page)
    {   


        
        return $this->displayMobileShopAction($shop_id,$page);

    }
    
    public function displayMobileShopFromMyMarketAction($shop_id,$page)
    {   

        return $this->displayMobileShopAction($shop_id,$page);

    }
    
}