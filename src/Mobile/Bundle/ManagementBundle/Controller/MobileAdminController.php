<?php

namespace Mobile\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;

class MobileAdminController extends Controller
{
    
    
    public function mobileAdminAction(Request $request,$page)
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $user = $this->getUser();
            
            $request->getSession()->set('current_user_id', $user->getId());

            /* This is a temporary solution because it uses a big SQL Query of another place to just count some value*/
            $messages= $this->get('shop_management.my_market.services')->getLatestPostsByFolloweds($user->getId());

            $sumArray=0;
            foreach ($messages as $k=>$subArray) {
                $sumArray+=(int)$subArray['countF'];
            }

            $categories= $this->get('shop_management.category.services')->getAllCategories();
            /* Items */
            $articlesPerPage = 10;
            $total_number_of_items= (int)$this->get('my_shop_controller')->getNumberOfAllItems();
            $entities = $this->get('my_shop_controller')->getAllPosts($page,$articlesPerPage);
                 
            $firstPart= array(
                'currentUser'=> $user,
                'categories' => $categories,
                'entities' =>  $entities,
                'number_of_pages'=> ceil($total_number_of_items/$articlesPerPage),
                'total_number_of_items'=> $total_number_of_items,
                'page' => $page

            );
            
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($user->getId());
            
            return $this->render('MobileManagementBundle::admin.html.twig', array_merge($firstPart, $secondPart));
        }
       else 
        { 
            $url = $this->generateUrl("mobile_fos_user_security_login");
            return $this->redirect($url);   
       }
    }
    
    
    public function searchAction(Request $request)
    {
        $SearchText = (string)$request->request->get('SearchText');
        
        $categories= $this->get('shop_management.category.services')->getAllCategories();
        
        if(strlen($SearchText) > 0)
        {
            $finder = $this->container->get('fos_elastica.finder.search.post');

            $articlesPerPage = 10;
            $paginator = $finder->findPaginated($SearchText);

            $paginator->setMaxPerPage($articlesPerPage);
            $countOfResults = $paginator->getNbResults();
            $resultsSet= $paginator->getCurrentPageResults();

            

            $firstPart = array(
                'entities' =>  $resultsSet,
                'number_of_pages'=> ceil($countOfResults/$articlesPerPage),
                'countOfResults' => $countOfResults,
                'searchText'=> $SearchText,
                'categories' => $categories,
                'page' => 0
            ); 
            
        }
        else
        {
            $firstPart = array(
                'entities' =>  null,
                'number_of_pages'=> 0,
                'countOfResults' => 0,
                'searchText'=> '',
                'categories' => $categories,
                'page' => 0);
        }
        
        
        
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') )
        {
            $user = $this->getUser();
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($user->getId());
            $finalArray= array_merge( $firstPart, $secondPart);
            
        }
        else
        {
            $finalArray= $firstPart;
        }
        
        return $this->render('MobileManagementBundle::mobileSearch.html.twig', $finalArray
            );
    }
    public function pageOfSearchAction($SearchText, $page)
    {   
        $finalPage= $page+1;
        $articlesPerPage = 10;
        $finder = $this->container->get('fos_elastica.finder.search.post');
        $paginator = $finder->findPaginated($SearchText);   
        $paginator->setMaxPerPage($articlesPerPage);
        $paginator->setCurrentPage($finalPage);

        $countOfResults = $paginator->getNbResults();
        
        $resultsSet= $paginator->getCurrentPageResults();

        $categories= $this->get('shop_management.category.services')->getAllCategories();        
        
        $firstPart = array(
            'entities' =>  $resultsSet,
            'number_of_pages'=> ceil($countOfResults/$articlesPerPage),
            'countOfResults' => $countOfResults,
            'searchText'=> $SearchText,
            'categories' => $categories,
            'page' => $page
        );
        
                
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') )
        {
            $user = $this->getUser();
            $secondPart= $this->get('mobile_management.menu.notification')->getMobileMenuNotifications($user->getId());
            $finalArray= array_merge( $firstPart, $secondPart);
            
        }
        else
        {
            $finalArray= $firstPart;
        }
        
        
        return $this->render('MobileManagementBundle::mobileSearch.html.twig', $finalArray
                );
    }
    
}
