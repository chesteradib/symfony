<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\Bundle\ManagementBundle\Entity\Post;
use Shop\Bundle\ManagementBundle\Entity\Image;
use Shop\Bundle\ManagementBundle\Form\PostType;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
       
        $entity = $em->getRepository('ShopManagementBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        
        $html = $this->renderView('ShopManagementBundle:Post:show.html.twig', array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView()
               ) );
        $status= true;
        $response = new Response(json_encode( 
                array("html" => $html, "target" => "show", "status" => $status) )
                );
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    } 

    /**
     * Finds and displays a Post entity.
     *
     */
    public function globalShowAction($id)
    {
        return new Response("globalShow" . $id);
    } 
    
    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editsAction($id)
    {
        $me = $this->getUser();
        if($me)
        {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('ShopManagementBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }
            
            if ($entity->getUser()== $me) {
                $editForm = $this->createForm( PostType::class, $entity);
                $deleteForm = $this->createDeleteForm($id);

                $html = $this->renderView('ShopManagementBundle:Post:edit.html.twig', array(
                    'id' => $id,
                    'entity'      => $entity,
                    'main_image_id' => $entity->getPostMainImagePath()->getId(),
                    'edit_form'   => $editForm->createView(),
                    'delete_form'   => $deleteForm->createView()  
                ));

                $status = true;
                $message = $html;
                $responseArray =array("status" => $status,
                    "target" => "",
                    "html" => $html);
                
                $response = new Response(json_encode($responseArray));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
            else
            {
                $status = false;
                $message = "You are not the post owner to perform this";
                $responseArray =array("status" => $status,
                    "target" => "",
                    "message" => $message);
                
                $response = new Response(json_encode($responseArray));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }   
        }
        else
        {
            $status = false;
            $message = "You are not connected!";
            $responseArray =array(
                "status" => $status,
                "target" => "",
                "message" => $message);

            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

    /**
    * Creates a form to edit a Post entity.
    *
    * @param Post $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Post $entity)
    {
        $form = $this->createForm( PostType::class, $entity);

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Post entity.
     *
     */
    public function updatesAction(Request $request,$id)
    {   
        $status= false;
        $html= '';
        $message = '';
        
        $me = $this->getUser();
        if($me)
        {
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ShopManagementBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to findddddd Post entity.');
            }
            
            if ($entity->getUser()== $me) {
                $deleteForm = $this->createDeleteForm($id);
                $editForm = $this->createEditForm($entity);
                $editForm->handleRequest($request);

                $dirty_images= $entity->getImages();
                $dirty_categories= $entity->getCategories();
        
                foreach($dirty_images as $di)
                {
                        $entity->removeImage($di);
                }
                foreach($dirty_categories as $dc)
                {
                    $entity->removeCategory($dc);
                }

                $result=$this->get('request')->request->get('result');
                if ($result)
                {
                    foreach( $result as $res)
                    {
                        $image = $em->getRepository('ShopManagementBundle:Image')->find((int)$res);
                        if (!$image) {
                            throw $this->createNotFoundException('Unable to find it Image entity');
                        }
                        $entity->addImage($image);
                    }
                }
                $result2= $request->request->get('shop_bundle_managementbundle_posttype')['categories'];

                if ($result2 && !empty($result2[0]))
                {
                    $category = $em->getRepository('ShopManagementBundle:Category')->find((int)$result2[0]);
                    if (!$category) {
                        throw $this->createNotFoundException('Unable to find that Category entity');
                    }
                    $entity->addCategory($category);
                    if($category->getParent()) $entity->addCategory($category->getParent());

                }
                
                $mainImageId=(int)$this->get('request')->request->get('main-image');

                $value=0;
                if ($mainImageId!=0)
                {
                    $mainImage = $em->getRepository('ShopManagementBundle:Image')->find((int)$mainImageId);
                    if (!$mainImage) {
                        throw $this->createNotFoundException('Unable to find MAin Image entity');
                    }
                    $entity->setPostMainImagePath($mainImage);
                    $value= $entity->getPostMainImagePath()->getId();
                }
                else
                {
                    $value=0;
                }


                if ($editForm->isValid()) {
                    $em->persist($entity);
                    $em->flush();

                    return $this->showAction($id);
                }


                $html = $this->renderView('ShopManagementBundle:Post:edit.html.twig', array(
                    'id' => $id,
                    'entity'      => $entity,
                    'main_image_id' => $value,
                    'edit_form'   => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
                $status= true;
                $response = new Response(json_encode( 
                        array("html" => $html, 
                            "target" => "form",
                            "status" => $status) )
                    );
                $response->headers->set('Content-Type', 'application/json');

                return $response; 
            }
            else
            {
                $status = false;
                $message = "You are not the post owner to perform this";
                $responseArray =array("status" => $status,
                    "target" => "",
                    "message" => $message);
                
                $response = new Response(json_encode($responseArray));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
            
        }
        else
        {
            $status = false;
            $message = "You are not connected!";
            $responseArray =array(
                "status" => $status,
                "target" => "",
                "message" => $message 
                    );

            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        
    }
       
    /**
     * Deletes a Post entity.
     *
     */             
    public function deletesAction(Request $request,$id)
    {
        $status= false;
        $message = '';
        $me = $this->getUser();
        if($me)
        {
            $form = $this->createDeleteForm($id);
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('ShopManagementBundle:Post')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Post entity.');
                }
                
                if($entity->getUser()!=$me)
                {
                    $status = false;
                    $message = 'You are not alowed!';
                    $responseArray =array("status" => $status,"message" => $message );
                    
                    $response = new Response(json_encode($responseArray));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }

                $em->remove($entity);
                $em->flush();
            }
            $status = true;
            $message = 'Item deleted!';
            $responseArray =array("status" => $status,"message" => $message );
            
            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        else
        {   $status = false;
            $message = 'You are not connected!';
            $responseArray =array("status" => $status,"message" => $message );
            
            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
 
    
    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $entity)
    {
        $form = $this->createForm( PostType::class , $entity, array(
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Post entity.
     *
     */
    public function newAction()
    {
        $status= false;
        $message = '';
        $me = $this->getUser();
        if($me)
        {
            $entity = new Post();
            $form   = $this->createCreateForm($entity);

            $html = $this->renderView('ShopManagementBundle:Post:new.html.twig', array(
                'entity' => $entity,
                'main_image_id' => null,
                'form'   => $form->createView()
            ));
            $status= true;
            $response = new Response(json_encode( 
                    array("status" => $status,"html" => $html) )
                    );
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        else
        {
            $status = false;
            $message = 'You are not connected!';
            $responseArray =array("status" => $status,"message" => $message);
            
            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
    
    
    
     /**
     * Creates a new Post entity.
     *
     */
    public function createsAction(Request $request)
    {
        $status= false;
        $message = '';
        $me = $this->getUser();
        if($me)
        {
            $entity = new Post();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            $dirty_images= $entity->getImages();
            $dirty_categories= $entity->getCategories();

            foreach ($dirty_images as $di)
            {
                    $entity->removeImage($di);
            }
            foreach ($dirty_categories as $dc)
            {
                $entity->removeCategory($dc);
            }

            $em = $this->getDoctrine()->getManager();

            $result= $this->get('request')->request->get('result');

            if ($result)
            {
                foreach( $result as $res)
                {
                    $image = $em->getRepository('ShopManagementBundle:Image')->find((int)$res);
                    if (!$image) {
                        throw $this->createNotFoundException('Unable to find it Post entity');
                    }
                    $entity->addImage($image);
                }
            }

            $result2= $request->request->get('shop_bundle_managementbundle_posttype')['categories'];

            if ($result2 && !empty($result2[0]))
            {
                $category = $em->getRepository('ShopManagementBundle:Category')->find((int)$result2[0]);
                if (!$category) {
                    throw $this->createNotFoundException('Unable to find that Category entity');
                }
                $entity->addCategory($category);
                if($category->getParent()) $entity->addCategory($category->getParent());

            }

            $mainImageId=$this->get('request')->request->get('main-image');

            if ($mainImageId)
            {
                $mainImage = $em->getRepository('ShopManagementBundle:Image')->find((int)$mainImageId);
                if (!$mainImage) {
                    throw $this->createNotFoundException('Unable to find MAin Image entity');
                }

                $entity->setPostMainImagePath($mainImage);
                if ($form->isValid()) {

                    $user = $this->getUser();
                    $entity->setUser($user);

                    $date= new \DateTime();
                    $entity->setPostDate($date);

                    $entity->setPoststatus('p');

                    $entity->setBought(false);

                    $place = $em->getRepository('ShopManagementBundle:Place')->findByName(array('Kenitra'));
                    $entity->setPostPlace($place[0]);

                    $em->persist($entity);
                    $em->flush();

                    /* Notify followers of the new Post*/
                    if ($user->getProfilePicture())
                    {
                        $followedProfilePictureUrl =  $user->getProfilePicture()->getPath();
                        $followedProfilePictureWidthVsHeight =  $user->getProfilePicture()->getWidthVsHeight();
                    }
                    else
                    {
                        $followedProfilePictureUrl =  'web/pp/index.png';
                        $followedProfilePictureWidthVsHeight =  0;
                    }


                    $followers= array_map('current', $this->get('members_management.follow.services')->getFollowers($user->getId()));

                    $context=  new \ZMQContext;
                    $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my_pusher');

                    $socket->connect('tcp://localhost:5555');

                    $pushData= array(
                                'type' => 'my_market',
                                'followed_name' => $user->getUsername(),
                                'followed_id' => $user->getId(),
                                'followers' => $followers,
                                'followed_profile_picture_url' => $followedProfilePictureUrl,
                                'followed_profile_picture_widthVsHeight' => $followedProfilePictureWidthVsHeight,
                                'date' => $date
                                ); 

                    $socket->send(json_encode($pushData));

                    return $this->showAction($entity->getId());
                }
            }

            $html = $this->renderView('ShopManagementBundle:Post:new.html.twig', array(
                'entity' => $entity,
                'main_image_id' =>$mainImageId,
                'form'   => $form->createView()
            ));
            $status = true;
            $response = new Response(json_encode( 
                    array("status" => $status, "html" => $html, "target" => "form") )
                    );
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        else
        {
            $status = false;
            $message = 'You are not connected!';
            $responseArray =array("status" => $status,"message" => $message);
            
            $response = new Response(json_encode($responseArray));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

    }
    

    public function boughtAction(Request $request,$post_id)
    {
        $response=array();
        $status=false;
        $message='';
        
        $me = $this->getUser();
        
        if($me){            
            if($request->isXmlHttpRequest())
            {
                $checked=(int)$request->request->get('checked');

                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository('ShopManagementBundle:Post')->find($post_id);
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Post entity.'); 
                }                    
                
                if($entity->getUser()== $me) {
                    if($entity->getBought() && $checked==1) 
                    {
                        $entity->setBought(false);
                        $status = true;
                        $message = "This article was bought and now is not bought";
                        $responseArray =array("status" => $status,"message" => $message ); 
                    }
                    else if($entity->getBought() &&  $checked==0) 
                    {
                        $status = false;
                        $message = "This is an impossible case, value from server wasn't rendered correclty"; 
                        $responseArray =array("status" => $status,"message" => $message );
                    }
                    else if(!$entity->getBought() &&  $checked==1) 
                    {
                        $status = false;
                        $message = "This is an impossible case, value from server wasn't rendered correclty"; 
                        $responseArray =array("status" => $status,"message" => $message );
                    }
                    else
                    {
                        $entity->setBought(true);
                        $status = true;
                        $message = "This article wasn't bought and now is bought";
                        $responseArray =array("status" => $status,"message" => $message );
                        
                    }
                    $em->persist($entity);
                    $em->flush();

                    
                }
                else
                {
                    $status = false;
                    $message = "You are not the post owner to perform this";
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
    
    public function retweetAction(Request $request,$post_id)
    {
        $response=array();
        $status=false;
        $message='';
        
        $me = $this->getUser();
        
        if($me){            
            if($request->isXmlHttpRequest())
            {
                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository('ShopManagementBundle:Post')->find($post_id);
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Post entity.'); 
                }                    
                
                if($entity->getUser()== $me) {

                    $lastDate= $entity->getPostDate();
                    $dateNow= new \DateTime();

                    $diff = date_diff($dateNow, $lastDate);
                    //var_dump($diff->days); die;
                    if($diff->days > 0 )
                    {
                        $status = true;
                        $message = "Your item is retweeted";
                        $responseArray =array("status" => $status,"message" => $message ); 
                        
                        $entity->setPostDate($dateNow);
                        $em->persist($entity);
                        $em->flush(); 
                    }
                    else
                    {
                        $status = false;
                        $message = "You can retweet an article only once per day";
                        $responseArray =array("status" => $status,"message" => $message ); 

                    }
                    
                                     
                }
                else
                {
                    $status = false;
                    $message = "You are not the post owner to perform this";
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
}