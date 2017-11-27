<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Members\Bundle\ManagementBundle\Entity\Follow;


use Symfony\Component\HttpFoundation\Response;

class MobileFollowController extends Controller
{
    public function mobileAllMyFollowedsAction(Request $request, $page)
    {
        $me = $this->getUser();
        if($me){
            $user= $this->get('security.context')->getToken()->getUser();
            $current_user_id= $user->getId();
            $follows= $this->get('members_management.follow.services')->getFollowedsAsEntities($current_user_id);
            $itemsPerPage = 10;
            
            $followedsAndRelatedData =  array();
            foreach($follows as $follow)
            {
                $followedsAndRelatedData[]= array(
                    'item' => $follow,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($follow->getFollowed()->getId()),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowersOfUser( $follow->getFollowed()->getId())
                    
                );
                
            }
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            
            $firstPart =array(
                'followeds_and_related_data' => $followedsAndRelatedData,
                'number_of_pages'=> ceil($this->get('members_management.follow.services')->getNumberOfFollowedsByCurrentUser($current_user_id)/$itemsPerPage),
                'categories' => $categories,
                'page' => $page
            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($me->getId());
            
            $finalArray= array_merge( $firstPart, $secondPart);
            
            
            
            return $this->render('MobileManagementBundle::mobileAllMyFollowedsFull.html.twig',$finalArray) ;
           
            }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
        
    }

    
    public function mobileAllMyNetworkAction(Request $request,$page)
    {
        $me = $this->getUser();
        if($me){
            $user= $this->get('security.context')->getToken()->getUser();
            $current_user_id= $user->getId();
            $follows= $this->get('members_management.follow.services')->getFollowersAsEntities($current_user_id);
            $itemsPerPage = 10;
            
            $followersAndRelatedData =  array();
            foreach($follows as $follow)
            {
                $followersAndRelatedData[]= array(
                    'item' => $follow,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($follow->getFollower()->getId()),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($follow->getFollower()->getId()),
                    'doesCurrentUserFollowThisUser' => $this->get('members_management.follow.services')->doesAUserFollowAUser( $user,$follow->getFollower()->getId()),
                );
                
            }
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $firstPart =array(
                'followers_and_related_data' => $followersAndRelatedData,
                'number_of_pages'=> ceil($this->get('members_management.follow.services')->getNumberOfFollowersOfUser($current_user_id)/$itemsPerPage),
                'categories' => $categories,
                'page' => $page
            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($me->getId());
            
            $finalArray= array_merge( $firstPart, $secondPart);
            
            
            return $this->render('MobileManagementBundle::mobileAllMyNetworkFull.html.twig', $finalArray);
        } 
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
        
    }
    
}