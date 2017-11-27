<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    
    public function getArticlesOfCategoryAction(Request $request)
    {
        $empty= false;
        if($request->isXmlHttpRequest())
        {
            $em= $this->getDoctrine()->getManager();
            
            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $categoryId = (int)$request->request->get('category_id');
            
            $posts = $this->get('my_shop_controller')->getPostsOfSpecificCategory($categoryId,0,$articlesPerPage);

            $total_number_of_items= $this->get('my_shop_controller')->getNumberOfItemsOfSpecificCategory($categoryId);
            
            if($total_number_of_items<=0)
            {
                $empty= true;
            }
            else
            {
                $empty= false;
            }

            $currentCategory = $em->getRepository('ShopManagementBundle:Category')->find($categoryId);
                if (!$currentCategory) {
                    throw $this->createNotFoundException('Unable to find that Category entity');
                }
                
            $html = $this->renderView('ShopManagementBundle:Category:Category.html.twig', array(            
                'entities' =>  $posts,
                'category_id' => $categoryId,
                'number_of_pages'=> ceil($total_number_of_items/$articlesPerPage),
                'total_number_of_items'=> $total_number_of_items,
                'category' => $currentCategory                    
            )); 
            $response = new Response(json_encode( 
                array("empty" => $empty, 
                        "status" => true, 
                        "html" => $html)
            ));
            $response->headers->set('Content-Type', 'application/json');
            
            return $response;
    
        }
        else return new Response('Not XMLHttpRequest');
    }
    
    
    public function getPageOfArticlesOfCategoryAction(Request $request, $category_id)
    {
            if($request->isXmlHttpRequest())
            {
                $articlesPerPage = (int)$request->request->get('articles_per_page');
                $page = (int)$request->request->get('page');
                
                $currentCategory = $em->getRepository('ShopManagementBundle:Category')->find($category_id);
                if (!$currentCategory) {
                    throw $this->createNotFoundException('Unable to find that Category entity');
                }
                $posts = $this->get('my_shop_controller')->getPostsOfSpecificCategory($category_id,$page,$articlesPerPage);
            
                return $this->render('ShopManagementBundle::items.html.twig', array(
                    'entities' => $posts,
                    'category' => $currentCategory
                    ));
                }
            else return new Response('Not XMLHttpRequest');
    }
 
}
