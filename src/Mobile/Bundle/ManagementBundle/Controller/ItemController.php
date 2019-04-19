<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\Bundle\ManagementBundle\Entity\Post;
use Shop\Bundle\ManagementBundle\Entity\Image;
use Shop\Bundle\ManagementBundle\Form\PostType;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Form\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ItemController extends Controller
{


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
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to create a new Post entity.
     *
     */
    public function mobileNewAction()
    {
        $me = $this->getUser();
        if($me)
        {
            $entity = new Post();
            $form   = $this->createCreateForm($entity);
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();
            $firstPart = array(
                'entity'      => $entity,
                'main_image_id' => null,
                'form'   => $form->createView(),
                'categories' => $categories
                );

            return $this->render('MobileManagementBundle::mobileNewFull.html.twig', $firstPart);
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
            
        }
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
        $form = $this->createForm(PostType::class, $entity, array(
        ));

        $form->add('submit',  SubmitType::class, array('label' => 'Create'));

        return $form;
    }
    

    /**
     * Creates a new Post entity.
     *
     */
    public function mobileCreatesAction(Request $request)
    {
        $me = $this->getUser();
        if($me)
        {
            $entity = new Post();

            $form = $this->createCreateForm($entity);

            $form->handleRequest($request);

            /* Clean up */
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

            $result= $request->request->get('result');

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

            }

            $mainImageId= $request->request->get('main-image');

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


                    return $this->redirect($this->generateUrl('mobile_item_show',
                            array('id' => $entity->getId())
                            ));
                }
            }
            
            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $firstPart = array(
                    'entity' => $entity,
                    'main_image_id' =>$mainImageId,
                    'form'   => $form->createView(),
                    'categories' => $categories 
                );

            
            return $this->render('MobileManagementBundle::mobileNewFull.html.twig', $firstPart );
            }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
    }
    
    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function mobileEditsAction($id)
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
                
                $categories= $this->get('shop_management.category.services')->getAllCategories();
                
                
                $firstPart = array(
                    'id' => $id,
                    'entity'      => $entity,
                    'main_image_id' => $entity->getPostMainImagePath()->getId(),
                    'edit_form'   => $editForm->createView(),
                    'delete_form'   => $deleteForm->createView(),
                    'orderedCategories' => $categories
                );

                
                
                return $this->render('MobileManagementBundle::mobileEditsFull.html.twig',$firstPart );
            }
            else
            {
                return new Response('You are not the post owner to perform this');   
            }
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
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
    public function mobileUpdatesAction(Request $request,$id)
    {   
        
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

            $result=$request->request->get('result');
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

                }
            $mainImageId=(int)$request->request->get('main-image');
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

                return $this->redirect($this->generateUrl('mobile_item_show', 
                        array('id' => $id)
                        )
                );
            }

            $categories= $this->get('shop_management.category.services')->getAllCategories();
            
            $firstPart = array(
                'id' => $id,
                'entity'      => $entity,
                'main_image_id' => $value,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'categories' => $categories
            );

            
            
            return $this->render('MobileManagementBundle::mobileEditsFull.html.twig', $firstPart);
        }
            else
            {
                return new Response('You are not the post owner to perform this');
            }
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url); 
        }
       
    }
       

  
}
