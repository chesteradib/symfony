<?php

namespace Members\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    const ITEMS_PER_PAGE = 10;

    /**
     *
     *
     */
    public function adminAction()
    {
        if($this->isUserConnected()){

            $connectedUser = $this->getConnectedUser();
            $categories = $this->getCategories();
            $connectedUserAndCategories = array_merge($connectedUser, $categories);

            return $this->render('MembersManagementBundle:AdminInitial:adminInitial.html.twig', $connectedUserAndCategories);
        }
       else 
        { 
           $url = $this->generateUrl("index");

           return $this->redirect($url);  
       }
    }

    /**
     *
     *
     */
    public function mobileAdminAction($page)
    {
        if($this->isUserConnected()){
            $connectedUser = $this->getConnectedUser();
            $categories = $this->getCategories();
            $pageItems = $this->getItemsOfPage($page);
            $connectedUserAndCategoriesAndPageItems = array_merge($connectedUser, $categories, $pageItems);

            return $this->render('MobileManagementBundle::admin.html.twig', $connectedUserAndCategoriesAndPageItems);
        }
        else
        {
            $url = $this->generateUrl("mobile_fos_user_security_login");

            return $this->redirect($url);
        }
    }

    /**
     *
     *
     */
    public function indexAction()
    {
        if($this->isUserConnected()){
            $url = $this->generateUrl("admin");

            return $this->redirect($url);
        }
        else
        {
            $categories = $this->getCategories();

            return $this->render('MembersManagementBundle:Index:index.html.twig', $categories);
        }
    }

    /**
     *
     *
     */
    public function mobileIndexAction($page)
    {
        if($this->isUserConnected()){
            $url = $this->generateUrl("mobile_admin", array( 'page' => $page));

            return $this->redirect($url);
        }
        else
        {
            $categories = $this->getCategories();
            $pageItems = $this->getItemsOfPage($page);
            $categoriesAndPageItems = array_merge($categories, $pageItems);

            return $this->render('MobileManagementBundle::index.html.twig', $categoriesAndPageItems);
        }
    }



    public function allNewPostersAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $itemsPerPage = (int)$request->request->get('items_per_page');

            $newPostersAndDates= $this->get('members_management.user.services')->getNewPostersAndDates(0, $itemsPerPage);

            $newPostersRelatedData =  array();
            foreach($newPostersAndDates as $newPoster)
            {
               $newPostersRelatedData[]= array(
                    'item' => $newPoster,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($newPoster)
                );   
            }
           
            return $this->render('MembersManagementBundle:User:all_new_posters.html.twig', array(
                'all_new_posters_and_related_data' => $newPostersRelatedData,
                'number_of_pages'=> ceil(count($this->get('members_management.user.services')->getNumberOfNewPosters())/$itemsPerPage)      
            ));
        }        
        else return new Response('Not XMLHttpRequest');
        
    }
    
    public function pageOfAllNewPostersAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $itemsPerPage = (int)$request->request->get('items_per_page');
            $page = (int)$request->request->get('current_page');
            
            $newPostersAndDates= $this->get('members_management.user.services')->getNewPostersAndDates($page,$itemsPerPage);

            $newPostersRelatedData =  array();
            foreach($newPostersAndDates as $newPoster)
            {
               $newPostersRelatedData[]= array(
                    'item' => $newPoster,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($newPoster)
                );   
            }
            return $this->render('MembersManagementBundle:User:all_new_posters_items.html.twig', array(
                'all_new_posters_and_related_data' => $newPostersRelatedData
                    
            ));
        }
        else 
        return new Response('It is not an XMLHttpRequest');
    }
    
    public function allJawlaItemsAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $page = (int)$request->request->get('page');
            
            return $this->render('ShopManagementBundle::items.html.twig', array(
                'entities' => $this->get('my_shop_controller')->getAllPosts($page,$articlesPerPage),
            ));
        }
        else return new Response('Not XMLHttpRequest');
    }
    
    public function allJawlaAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {

            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $total_number_of_items= (int)$this->get('my_shop_controller')->getNumberOfAllItems();
            
            
            if($total_number_of_items<=0)
            {
                $response = new Response(json_encode( 
                    array("status" => 0, "html" => $this->get('translator')->trans("center.no_items_in_home"))
                ));
            }
            else
            {
                $html = $this->renderView('MembersManagementBundle:AdminInitial:allJawla.html.twig', array(            
                    'entities' =>  $this->get('my_shop_controller')->getAllPosts(0,$articlesPerPage),
                    'number_of_pages'=> ceil($this->get('my_shop_controller')->getNumberOfAllItems()/$articlesPerPage),
                    'total_number_of_items'=> $total_number_of_items
                )); 
                $response = new Response(json_encode( 
                    array("status" => 1, "html" => $html )
                ));
            }

            $response->headers->set('Content-Type', 'application/json');
            
            return $response;
    
        }
        else 
        
            return new Response('Not XMLHttpRequest');
    }
    


    /**
     * Getting if user is granted authenticated_fully from authorization checker
     *
     * @return array
     */
    protected function getConnectedUser()
    {
        $user = $this->getUser();

        return array(
            'currentUser'=> $user,
        );
    }


    /**
     * Getting the connected user object and the list of categories
     *
     * @return boolean
     */
    protected function isUserConnected()
    {
        return $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * Get the categories ordered and grouped alphabetically
     *
     * @return array
     */
    protected function getCategories()
    {
        $categories= $this->get('shop_management.category.services')->getAllCategories();

        return [
            'orderedCategories' => $categories
        ];
    }

    /**
     * Getting the connected user object and the list of categories
     *
     * @return array
     */
    protected function getItemsOfPage($page)
    {
        $totalNumberOfItems= (int)$this->get('my_shop_controller')->getNumberOfAllItems();
        $items = $this->get('my_shop_controller')->getAllPosts($page,self::ITEMS_PER_PAGE);

        return array(
            'page' => $page,
            'number_of_pages'=> ceil($totalNumberOfItems/self::ITEMS_PER_PAGE),
            'entities' =>  $items,
            'total_number_of_items'=> $totalNumberOfItems,


        );
    }
}
