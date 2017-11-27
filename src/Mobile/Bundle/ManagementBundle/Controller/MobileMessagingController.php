<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Members\Bundle\ManagementBundle\Entity\Message;
use Members\Bundle\ManagementBundle\Form\MessageType;

use Symfony\Component\HttpFoundation\Response;


class MobileMessagingController extends Controller
{  
    public function mobileMyInboxAction(Request $request, $page)
    {
        $me = $this->getUser();
        if($me){
            $itemsPerPage = 10;

            $allMyMessages= $this->get('members_management.messages.services')->getAllMyMessages($me,(int)$page,$itemsPerPage);

            $numberOfUnseenMessagesByMe =count($this->get('members_management.messages.services')->getLatestMessagesForInboxReceivedBy($me));
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();          
            
            $firstPart = array(
                'number_of_all_inbox_messages' => $numberOfUnseenMessagesByMe,
                'all_my_messages' => $allMyMessages,
                'page' => $page,
                'articles_per_page' => $itemsPerPage,
                'number_of_pages'=> ceil($this->get('members_management.messages.services')->getNumberOfAllMyMessages($me)/$itemsPerPage),
                'categories' => $categories
            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($me->getId());
            
            $finalArray= array_merge($firstPart, $secondPart);

            return $this->render('MobileManagementBundle::mobileMyInboxFull.html.twig',$finalArray );
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
    }
    
    
    public function getDiscussionAboutPostWithAction($post_id, $shop_id){
        
        $me = $this->getUser();
        if($me){
            $em = $this->getDoctrine()->getManager();
            $interlocutor= $em->getRepository('MembersManagementBundle:User')->find($shop_id);
            $post= $em->getRepository('ShopManagementBundle:Post')->find($post_id);
                
            if(!$interlocutor || !$post) {
                throw $this->createNotFoundException('Unable to find Post or Receiver entity.');
            }

            if($post->getUser() !=$interlocutor  && $post->getUser() !=$me) {
                throw $this->createNotFoundException('Item dont belong to nieghter user nor receiver');
            }
            
            $message = new Message();
            $form   = $this->createForm(new MessageType(), $message);
            
            $messages= $this->get('members_management.messages.services')->getMessagesBetweenTwoUsersAboutArticle($me->getId(),$shop_id, $post_id);       
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $firstPart = array(
                'messages' =>  $messages,
                'form'   => $form->createView(),
                'interlocutor' => $interlocutor,
                'post' => $post,
                'categories' => $categories
            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($me->getId());
            
            $finalArray= array_merge( $firstPart, $secondPart);
            
            return $this->render('MobileManagementBundle::mobileDiscussionFull.html.twig',$finalArray );
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
    }
}
