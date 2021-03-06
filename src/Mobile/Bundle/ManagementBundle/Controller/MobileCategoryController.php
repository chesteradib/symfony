<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MobileCategoryController extends Controller
{
    
    public function mobileCategoryAction($categoryId, $page)
    {
        $em= $this->getDoctrine()->getManager();

        $articlesPerPage = 10;

        $posts = $this->get('my_shop_controller')->getPostsOfSpecificCategory($categoryId,$page,$articlesPerPage);

        $total_number_of_items= $this->get('my_shop_controller')->getNumberOfItemsOfSpecificCategory($categoryId);

        $categories= $this->get('shop_management.category.services')->getAllCategories();

        $currentCategory = $em->getRepository('ShopManagementBundle:Category')->find($categoryId);
            if (!$currentCategory) {
                throw $this->createNotFoundException('Unable to find that Category entity');
            }

        $firstPart = array(            
                'entities' =>  $posts,
                'category_id' => $categoryId,
                'number_of_pages'=> ceil($total_number_of_items/$articlesPerPage),
                'total_number_of_items'=> $total_number_of_items,
                'orderedCategories' => $categories,
                'page' => $page,
                'category' => $currentCategory
            );
 

        return $this->render('MobileManagementBundle::mobileCategory.html.twig', $firstPart
           );
    }

}

