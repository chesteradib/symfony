<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends Controller
{

    
    public function displayPostsAction(Request $request, $shop_id)
    {
        
        if($request->isXmlHttpRequest())
        {
            $page = (int)$request->request->get('page');
            $articlesPerPage = (int)$request->request->get('articles_per_page');

            return $this->render('ShopManagementBundle::items.html.twig', array(
            'entities' =>  $this->get('my_shop_controller')->getPostsOfSpecificShop($shop_id,$page,$articlesPerPage)
        )); 
        }
        else return new Response('Not XMLHttpRequest');
        
        
    }
    
    public function displayShopAction(Request $request, $shop_id)
    {
        if($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();

            $user= $em->getRepository('MembersManagementBundle:User')->find($shop_id);
            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $numberOfFollowersOfUser= $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($shop_id);
            $doesCurrentUserFollowThisUser= $this->get('members_management.follow.services')->doesAUserFollowAUser($user->getId(),$shop_id);
            
            $me= $this->getUser();
        
            if($me && $me->getId() != $shop_id){
                $this->get('my_shop_controller')->setLastDate($shop_id, $me->getId());

                $followSeen = $request->request->get('followSeen');

                if($followSeen) 
                {
                    $this->get('my_shop_controller')->setFollowSeen($shop_id, $me->getId());
                }
            }
            
            return $this->render('ShopManagementBundle:Shop:Shop.html.twig', array(
                'user' => $user,
                'doesCurrentUserFollowThisUser' => $doesCurrentUserFollowThisUser,
                'number_of_followers_of_user' => $numberOfFollowersOfUser,
                'entities' =>  $this->get('my_shop_controller')->getPostsOfSpecificShop($shop_id,0,$articlesPerPage),
                'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfArticles($shop_id)/$articlesPerPage),
                'total_number_of_items'=> $this->get('my_shop_controller')->getNumberOfArticles($shop_id)
            )); 
        }
        
        else return new Response('Not XMLHttpRequest');
    }
}
?>
