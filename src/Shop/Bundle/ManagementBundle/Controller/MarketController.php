<?php

namespace Shop\Bundle\ManagementBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Shop\Bundle\ManagementBundle\Entity\Post;


class MarketController extends Controller
{
    
    public function displayMarketPostsAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user = $this->getUser();
            
            $page = (int)$request->request->get('page');
            $articlesPerPage = (int)$request->request->get('articles_per_page');

            return $this->render('ShopManagementBundle::items.html.twig', array(
               'entities' => $this->get('shop_management.my_market.services')->getPostsByFolloweds($user->getId(),$page,$articlesPerPage)     
            )); 
        }
        else return new Response('Not XMLHttpRequest');
    }
    
    public function displayMyMarketAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $user = $this->getUser();
            
            $numberOfFollowedsByCurrentUser =$this->get('members_management.follow.services')->getNumberOfFollowedsByCurrentUser($user);
            
            return $this->render('ShopManagementBundle:myMarket:myMarket.html.twig', array(
               'entities' => $this->get('shop_management.my_market.services')->getPostsByFolloweds($user->getId(),0,$articlesPerPage) ,
               'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfMyMarketArticles($user->getId())/$articlesPerPage),
               'articles_per_page' => $articlesPerPage,
               'number_of_followeds_by_current_user' => $numberOfFollowedsByCurrentUser,
               'total_number_of_items'=> $this->get('my_shop_controller')->getNumberOfMyMarketArticles($user->getId())
            )); 

        }
        else return new Response('8');
    }
    
    public function myMarketDialogAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user = $this->getUser();

            $messages= $this->get('shop_management.my_market.services')->getLatestPostsByFolloweds($user->getId());

            return $this->render('ShopManagementBundle:myMarket:my_market_messages.html.twig', array(
                'messages' => $messages
            ));
        }
        else return new Response('Sorry, this is not accessible using your device');
    }
}

?>
