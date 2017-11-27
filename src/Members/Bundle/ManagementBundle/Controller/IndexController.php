<?php
namespace Members\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    public function indexAction()
    {
        //var_dump($this->get('session'));
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $url = $this->generateUrl("user_admin_page");
            return $this->redirect($url);
        }
        else 
        { 
           $categories= $this->get('shop_management.category.services')->getAllCategories();
           
           return $this->render('MembersManagementBundle:Index:index.html.twig', array(
               'categories' => $categories)
            ); 
       }
    }
    
    public function mobileAction( Request $request)
    {
        return new Response('ok');
        
    }

    
}
