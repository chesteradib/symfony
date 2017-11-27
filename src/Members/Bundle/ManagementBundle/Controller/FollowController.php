<?php

namespace Members\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Members\Bundle\ManagementBundle\Entity\Follow;


use Symfony\Component\HttpFoundation\Response;

class FollowController extends Controller
{
    public function followUnfollowAction(Request $request, $shop_id)
    {
        $response=array();
        $status=false;
        $message='';
        
        $user= $this->get('security.context')->getToken()->getUser();
        if($user)
        {
            if($request->isXmlHttpRequest())
            {
                $em = $this->getDoctrine()->getManager();
                
                $followed= $em->getRepository('MembersManagementBundle:User')->find($shop_id);
                if (!$followed) {
                    throw $this->createNotFoundException('Unable to find Followed user');
                }

                if($user!=$followed){

                    $does= $this->get('members_management.follow.services')->doesAUserFollowAUser($user->getId(),$shop_id);

                    $checked= (int)$request->request->get('checked');

                    if($checked && $does) {
                        
                        $repository = $this->getDoctrine()->getRepository('MembersManagementBundle:Follow');
                        
                        $follow = $repository->findBy(
                                array('follower' => $user
                                ,'followed' => $followed)
                            );
                        
                         if (!$follow) {
                            throw $this->createNotFoundException('Unable to find Follow entity.');
                        }

                        $em->remove($follow[0]);
                        $em->flush();
                        
                        
                        $status = true;
                        $message = "You were following this user and now you are not";
                        $responseArray =array("status" => $status,"message" => $message ); 


                    }
                    if($checked && !$does) {

                        $status = false;
                        $message = "Impossible case, the button is checked but no corresponding Follow in database";
                        $responseArray =array("status" => $status,"message" => $message );
                    }
                    if(!$checked && $does) {
                        
                        $status = false;
                        $message = "Impossible case, the button is  not checked but a corresponding Follow in database exists";
                        $responseArray =array("status" => $status,"message" => $message );

                    }
                    if(!$checked && !$does) {

                        $follow = new Follow();

                        $follow->setFollower($user);
                        $followed= $em->getRepository('MembersManagementBundle:User')->find($shop_id);
                        $follow->setFollowed($followed);
                        $follow->setFollowSeen(false);
                        $date= new \DateTime();
                        $follow->setLastDate($date);


                        $em->persist($follow);
                        $em->flush();

                        /*  Real Time notification of Followed */ 
                        if ($user->getProfilePicture())
                        {
                            $followerProfilePictureUrl =  $user->getProfilePicture()->getPath();
                            $followerProfilePictureWidthVsHeight =  $user->getProfilePicture()->getWidthVsHeight();
                        }
                        else
                        {
                            $followerProfilePictureUrl =  'web/pp/index.png';
                            $followerProfilePictureWidthVsHeight =  0;
                        }

                        $context=  new \ZMQContext;
                        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my_pusher');

                        $socket->connect('tcp://localhost:5555');


                        $pushData= array(
                            'type' => 'my_followers',
                            'followed_id' => $followed->getId(),
                            'follower_id' => $user->getId(),
                            'follower_username' => $user->getUsername(),
                            'follower_profile_picture_url' => $followerProfilePictureUrl,
                            'follower_profile_picture_widthVsHeigth' => $followerProfilePictureWidthVsHeight
                            ); 

                        $socket->send(json_encode($pushData));

                        //var_dump(json_encode($pushData));
                        /*  Real Time notification of Followed */ 

                        $status = true;
                        $message = "You are Successfully following the user";
                        $responseArray =array("status" => $status,"message" => $message );

                    }
     
                }
                else
                {
                    $status = false;
                    $message = "You cannot followe yourself";
                    $responseArray =array("status" => $status,"message" => $message );

                }
                    
                $response = new Response(json_encode($responseArray));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
                
            }
            else
            {
               return new Response("Not xml http request");    
            }
            
        }
        // You are not connected
        else
        {
            $status = false;
            $message = "You are not connected!";
            $responseArray =array("status" => $status,"message" => $message );

            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }   
    
    public function networkMessagesAction()
    {
        $user= $this->get('security.context')->getToken()->getUser();
        $current_user_id= $user->getId();
        $follows= $this->get('members_management.follow.services')->getNewFollowers($current_user_id);
        /*
        var_dump($follows);
        
        return new Response('ok');
        */
        return $this->render('MembersManagementBundle:Follow:network_messages.html.twig', array(
            'follows' => $follows
        ));
        
        
    }
    
    public function followSeenAction(Request $request)
    {
        
        if($request->isXmlHttpRequest())
        {
          
          $user= $this->get('security.context')->getToken()->getUser();
          $current_user_id= $user->getId();
          
          $follower_id= (int)$request->request->get('follower_id');
            
          $em = $this->getDoctrine()->getManager();
            
          $follow=$this->get('members_management.follow.services')->getFollowByFollowerAndFollowed($current_user_id,$follower_id);   
        
          if (!$follow) {
                    throw $this->createNotFoundException('Unable to find Follow entity.');
                }
          
          $follow->setFollowSeen(true);
          $followSeenDate=new \DateTime();
          $follow->setLastDate($followSeenDate);
          
          
          $em->persist($follow);
          $em->flush();
          
        }
        return new Response('ok');
    }
    
    public function lastDateAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
          $user= $this->get('security.context')->getToken()->getUser();
          $current_user_id= $user->getId();
        
          $shop_id= (int)$request->request->get('shop_id');
          
          $does=$this->get('members_management.follow.services')->doesAUserFollowAUser($current_user_id, $shop_id); 
          
          if($does)
          {
               $em = $this->getDoctrine()->getManager();
               $follow=$this->get('members_management.follow.services')->getFollowByFollowerAndFollowed($shop_id,$current_user_id);     
              
                if (!$follow) {
                          throw $this->createNotFoundException('Unable to find Follow entity.');
                      }
        
                $lastDate=new \DateTime();;
                $follow->setLastDate($lastDate);

                $em->persist($follow);
                $em->flush();
          }
        }
        return new Response('ok');
        
    }
    
    public function allMyFollowedsAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user= $this->get('security.context')->getToken()->getUser();
            $current_user_id= $user->getId();
            $follows= $this->get('members_management.follow.services')->getFollowedsAsEntities($current_user_id);
            $itemsPerPage = (int)$request->request->get('items_per_page');
            
            $followedsAndRelatedData =  array();
            foreach($follows as $follow)
            {
                $followedsAndRelatedData[]= array(
                    'item' => $follow,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($follow->getFollowed()->getId()),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowersOfUser( $follow->getFollowed()->getId())
                    
                );
                
            }

            return $this->render('MembersManagementBundle:Follow:all_my_followeds.html.twig', array(
                'followeds_and_related_data' => $followedsAndRelatedData,
                'number_of_pages'=> ceil($this->get('members_management.follow.services')->getNumberOfFollowedsByCurrentUser($current_user_id)/$itemsPerPage)      
            ));
           
        }
        else return new Response('Not XMLHttpRequest');
        
    }
    
    public function pageOfAllMyFollowedsAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user= $this->get('security.context')->getToken()->getUser();
            $current_user_id= $user->getId();
            $follows= $this->get('members_management.follow.services')->getFollowedsAsEntities($current_user_id);

            $followedsAndRelatedData =  array();
            foreach($follows as $follow)
            {
                $followedsAndRelatedData[]= array(
                    'item' => $follow,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($follow->getFollowed()->getId()),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowedsOfUser($follow->getFollowed()->getId())
                );
                
            }

            return $this->render('MembersManagementBundle:Follow:all_my_followeds_items.html.twig', array(
                'followeds_and_related_data' => $followedsAndRelatedData
            ));
        }
        else 
        return new Response('It is not an XMLHttpRequest');
    }
    
    
    
    
    public function allMyNetworkAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user= $this->get('security.context')->getToken()->getUser();
            $current_user_id= $user->getId();
            $follows= $this->get('members_management.follow.services')->getFollowersAsEntities($current_user_id);
            $itemsPerPage = (int)$request->request->get('items_per_page');
            
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

            return $this->render('MembersManagementBundle:Follow:all_my_network.html.twig', array(
                'followers_and_related_data' => $followersAndRelatedData,
                'number_of_pages'=> ceil($this->get('members_management.follow.services')->getNumberOfFollowersOfUser($current_user_id)/$itemsPerPage)      
            ));
           
        }
        else return new Response('Not XMLHttpRequest');
        
    }
    public function pageOfAllMyNetworkAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user= $this->get('security.context')->getToken()->getUser();
            $current_user_id= $user->getId();
            $follows= $this->get('members_management.follow.services')->getFollowersAsEntities($current_user_id);
            
            
            $followersAndRelatedData =  array();
            foreach($follows as $follow)
            {
                $followersAndRelatedData[]= array(
                    'item' => $follow,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($follow->getFollower()->getId()),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($follow->getFollower()->getId()),
                    'doesCurrentUserFollowThisUser' => $this->get('members_management.follow.services')->doesAUserFollowAUser($current_user_id,$follow->getFollower()->getId()),
                );
                
            }

            return $this->render('MembersManagementBundle:Follow:all_my_network_items.html.twig', array(
                'followers_and_related_data' => $followersAndRelatedData
            ));
        }
        else 
        return new Response('It is not an XMLHttpRequest');
    }
    
}