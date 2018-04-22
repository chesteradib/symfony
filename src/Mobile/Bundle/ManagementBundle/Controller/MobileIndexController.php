<?php
namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MobileIndexController extends Controller
{
    public function mobileIndexAction($page)
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            $url = $this->generateUrl("mobile_admin", array( 'page' => $page));
            return $this->redirect($url);
        }
       else 
        { 
           $categories= $this->get('shop_management.category.services')->getAllCategories();
           
           /* Items */
           $articlesPerPage = 10;
           $total_number_of_items= (int)$this->get('my_shop_controller')->getNumberOfAllItems();
           $entities = $this->get('my_shop_controller')->getAllPosts($page,$articlesPerPage);
           
           return $this->render('MobileManagementBundle::index.html.twig', array(
                'categories' => $categories,
                'entities' =>  $entities,
                'number_of_pages'=> ceil($total_number_of_items/$articlesPerPage),
                'total_number_of_items'=> $total_number_of_items,
                'page' => $page
                   )
            ); 
       }
    }

}

