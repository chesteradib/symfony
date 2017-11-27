<?php

namespace Members\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Members\Bundle\ManagementBundle\Entity\Message;
use Members\Bundle\ManagementBundle\Form\MessageType;

use Symfony\Component\HttpFoundation\Response;




class MessagesController extends Controller
{
    
    public function newMessageAction($receiver_id,$post_id)
    {
        $message = new Message();
        $form   = $this->createForm(new MessageType(), $message);
        
        
        return $this->render('MembersManagementBundle:Messages:new.html.twig', array(
            'form'   => $form->createView(),
            'post_author_id' => $receiver_id,
            'post_id' => $post_id
        ));
    }
    
    public function addMessageAction(Request $request,$receiver_id,$post_id)
    {
        if($request->isXmlHttpRequest())
        {
            $user = $this->getUser();
            if($user)
            {
                $em = $this->getDoctrine()->getManager();
                $receiver= $em->getRepository('MembersManagementBundle:User')->find($receiver_id);
                $post= $em->getRepository('ShopManagementBundle:Post')->find($post_id);
                
                if (!$receiver || !$post) {
                    throw $this->createNotFoundException('Unable to find Post or Receiver entity.');
                }
                
                if ($post->getUser() !=$receiver  && $post->getUser() !=$user) {
                    throw $this->createNotFoundException('Item dont belong to nieghter user nor receiver');
                }
                   
                $message = new Message();
                $form = $this->createForm(new MessageType(), $message);       
                $form->bind($request);

                if($form->isValid()){
                                        
                    $message->setSender($user);

                    $date= new \DateTime();
                    $message->setMessageDate($date);
  
                    $message->setReceiver($receiver);
                    $message->setMessageSeen(false);
                    
                    $message->setPost($post);

                    $message->setPostOwner($post->getUser());
                   
                    $em->persist($message);
                    $em->flush();

                    $file = $post->getPostMainImagePath()->getPath();

                    $year= $post->getPostMainImagePath()->getUploadDate()->format('Y');
                    $month= $post->getPostMainImagePath()->getUploadDate()->format('m');
                    $day= $post->getPostMainImagePath()->getUploadDate()->format('d');
                    $hour= $post->getPostMainImagePath()->getUploadDate()->format('H');

                    $subDirString= $year. DIRECTORY_SEPARATOR .$month. DIRECTORY_SEPARATOR .$day. DIRECTORY_SEPARATOR .$hour;

                    $spath= $subDirString. DIRECTORY_SEPARATOR .'s_'.$file;

                    /* Notify receiver of new message */ 
                    $context = new \ZMQContext();
                    $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
                    $socket->connect("tcp://localhost:5555");

                    $pushData = array(
                           'type' => 'my_inbox',
                           'receiver_id' => $receiver_id,
                           'sender_id' => $user->getId(),
                           'post_id' => $post->getId(),
                           'post_main_image_path' => $spath,
                           'post_main_image_widthVsHeight' => $post->getPostMainImagePath()->getWidthVsHeight(),
                           'sender_profile_picture_path'  => $user->getProfilePicture()->getPath(),
                           'sender_profile_picture_widthVsHeight' => $user->getProfilePicture()->getWidthVsHeight(),
                           'message_date' => $message->getMessageDate(),
                           'sender_username' => $user->getUsername(),
                           'message_content' => $message->getMessageContent(),
                           'message_id' => $message->getId()
                        );
                    $socket->send(json_encode($pushData));
                    /* End notification */
                
                    $responseArray =array("status" => true,"message" => "OK" );
                }
                else{
                    $responseArray = array("status" => false,"message" => "The data was not valid according to security policies! Try to reconnect with valid account!" ) ;
                }
                
                $response = new Response(json_encode($responseArray));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
                
                }
            else // $user is NULL
            {
                $responseArray= array("status" => false,"message" => "You are not Connected!" );
                $response = new Response(json_encode($responseArray));
                $response->headers->set('Content-Type', 'application/json');
                return $response;  
            }
               
        }
        else // $request is not AJAX
        {
            return new Response("You Cannot Access this page");   
        }
    }
    
    
    public function inboxMessagesAction($receiver_id)
    {        
        $messages= $this->get('members_management.messages.services')->getLatestMessagesForInboxReceivedBy($receiver_id);
        
        //var_dump($messages);
        return $this->render('MembersManagementBundle:Messages:inbox_messages.html.twig', array(
            'messages' => $messages
        )); 
    }

    
    public function getMessagesBetweenTwoUsersAboutArticleAction($sender_id,$receiver_id, $post_id)
    {  
        $messages= $this->get('members_management.messages.services')->getMessagesBetweenTwoUsersAboutArticle($sender_id,$receiver_id, $post_id);

        return $this->render('MembersManagementBundle:Messages:messages_between_two_users_about_article.html.twig', array(
            'messages' => $messages
        ));
    }
    
    public function messageSeenAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $message_id=(int)$request->request->get('message_id');
            
            $em= $this->getDoctrine()->getManager();
            
            $message= $em->getRepository('MembersManagementBundle:Message')->find($message_id);
            
            if(!$message)
            {
                throw $this->createNotFoundException('Unable to find the Message item with that Id');  
            }
            $message->setMessageSeen(true);
            $em->persist($message);
            $em->flush();
            
            return new Response('ok'); 
        }
        else 
        return new Response('Not XMLHttpRequest');
    }
    
    public function messagesSeenAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $user = $this->getUser();
            if($user)
            {
                $sender_id=(int)$request->request->get('sender_id');
                $receiver_id=$user->getId();
                $post_id=(int)$request->request->get('post_id');

                $em= $this->getDoctrine()->getManager();

                $messages= $this->get('members_management.messages.services')->getMessagesNotSeenByMeForSpecificPostAndSender($sender_id,$receiver_id, $post_id);
                var_dump($messages);
                foreach($messages as $message)
                {
                    $message->setMessageSeen(true);
                    $em->persist($message);
                    $em->flush();

                }
                return new Response('ok');
            }
        }
        else 
        return new Response('Not XMLHttpRequest');
    }
    
    
    public function allMyInboxAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $me = $this->getUser();
            if($me)
            {    
                $itemsPerPage = (int)$request->request->get('items_per_page');

                $allMyMessages= $this->get('members_management.messages.services')->getAllMyMessages($me,0,$itemsPerPage);
                $numberOfUnseenMessagesByMe =count($this->get('members_management.messages.services')->getLatestMessagesForInboxReceivedBy($me));

                return $this->render('MembersManagementBundle:Messages:all_my_inbox.html.twig', array(
                    'number_of_all_inbox_messages' => $numberOfUnseenMessagesByMe,
                    'all_my_messages' => $allMyMessages,
                    'number_of_pages'=> ceil($this->get('members_management.messages.services')->getNumberOfAllMyMessages($me)/$itemsPerPage)
                ));
            }
            else
            {
                return new Response('You are not connected');
            }
        }
        else 
        return new Response('It is not an XMLHttpRequest');
    }
    
    
    public function pageOfAllMyInboxAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $me = $this->getUser();
            if($me)
            { 
                $page = (int)$request->request->get('current_page');
                $messagesPerPage = (int)$request->request->get('items_per_page');

                $allMyMessages= $this->get('members_management.messages.services')->getAllMyMessages($me,$page,$messagesPerPage);

                $numberOfAllMessages = count($allMyMessages);

                $numberOfUnseenMessagesByMe =count($this->get('members_management.messages.services')->getLatestMessagesForInboxReceivedBy($me));


                return $this->render('MembersManagementBundle:Messages:all_my_inbox_items.html.twig', array(
                    'number_of_all_inbox_messages' => $numberOfUnseenMessagesByMe,
                    'all_my_messages' => $allMyMessages
                ));
            }
            else
            {
                return new Response('You are not connected');
            }
        }
        else 
        return new Response('It is not an XMLHttpRequest');
    }
}
