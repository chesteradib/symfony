<?php

namespace Members\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    
    /* action for admin area */
    public function adminAction(Request $request)
    {
        if( $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $user = $this->getUser();
        
            $request->getSession()->set('current_user_id', $user->getId());

            $numberOfFollowersOfCurrentUser= $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($user->getId());

            $numberOfMessagesNotSeen= $this->get('members_management.messages.services')->getNumberOfMessagesNotSeenByReceiver($user->getId());

            $numberOfFollowsNotSeen= $this->get('members_management.follow.services')->getNumberOfFollowsNotSeenByFollowed($user->getId());

            /* This is a temporary solution because it uses a big SQL Query of another place to just count some value*/
            /*
            $messages= $this->get('shop_management.my_market.services')->getLatestPostsByFolloweds($user->getId());

            $sumArray=0;
            foreach ($messages as $k=>$subArray) {
                $sumArray+=(int)$subArray['countF'];
            }
            */
            $categories= $this->get('shop_management.category.services')->getAllCategories();

            return $this->render('MembersManagementBundle:AdminInitial:adminInitial.html.twig', array(
                'currentUser'=> $user,
                'number_of_followers_of_current_user' => $numberOfFollowersOfCurrentUser,
                'number_of_messages_not_seen' => $numberOfMessagesNotSeen,
                'number_of_follows_not_seen' => $numberOfFollowsNotSeen,
                'number_of_new_posts_by_followeds_not_seen' => 0,
                'categories' => $categories

            ));
        }
       else 
        { 
           $url = $this->generateUrl("index");
           return $this->redirect($url);  
       }
    }
    
    
    public function allNewPostersAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $itemsPerPage = (int)$request->request->get('items_per_page');
            
            $user= $this->get('security.context')->getToken()->getUser();
            $newPostersAndDates= $this->get('members_management.user.services')->getNewPostersAndDates(0, $itemsPerPage);

            $newPostersRelatedData =  array();
            foreach($newPostersAndDates as $newPoster)
            {
               $newPostersRelatedData[]= array(
                    'item' => $newPoster,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($newPoster),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($newPoster->getId()),
                    'doesCurrentUserFollowThisUser' => $this->get('members_management.follow.services')->doesAUserFollowAUser( $user,$newPoster->getId()),
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
            
            $user= $this->get('security.context')->getToken()->getUser();
            $newPostersRelatedData =  array();
            foreach($newPostersAndDates as $newPoster)
            {
               $newPostersRelatedData[]= array(
                    'item' => $newPoster,
                    'number_of_articles' =>  $this->get('my_shop_controller')->getNumberOfArticles($newPoster),
                    'number_of_followers' => $this->get('members_management.follow.services')->getNumberOfFollowersOfUser($newPoster->getId()),
                    'doesCurrentUserFollowThisUser' => $this->get('members_management.follow.services')->doesAUserFollowAUser( $user,$newPoster->getId()),
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
    
    public function searchAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $finder = $this->container->get('fos_elastica.finder.search.post');
            $SearchText = $request->request->get('SearchText');
            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $paginator = $finder->findPaginated($SearchText);

            $paginator->setMaxPerPage($articlesPerPage);
            $countOfResults = $paginator->getNbResults();
            $resultsSet= $paginator->getCurrentPageResults();


            return $this->render('ShopManagementBundle:Search:Search.html.twig', array(
                'entities' =>  $resultsSet,
                'number_of_pages'=> ceil($countOfResults/$articlesPerPage),
                'countOfResults' => $countOfResults,
                'searchText'=> $SearchText
            )); 
        }
        else return new Response('Not XMLHttpRequest');
    }
    
    public function pageOfSearchAction(Request $request, $search_text)
    {
        if($request->isXmlHttpRequest())
        {

            $page = (int)$request->request->get('page');
            $articlesPerPage = (int)$request->request->get('articles_per_page');
            $finder = $this->container->get('fos_elastica.finder.search.post');
            $page++;
            $paginator = $finder->findPaginated($search_text);   
            
            $paginator->setMaxPerPage($articlesPerPage);
            $paginator->setCurrentPage($page);

            $resultsSet= $paginator->getCurrentPageResults();
            
            return $this->render('ShopManagementBundle::items.html.twig', array(
                'entities' =>  $resultsSet,
            )); 
        }
        else return new Response('Not XMLHttpRequest');
        
    }
}
