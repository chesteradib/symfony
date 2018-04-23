<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SearchController extends Controller
{
    const ITEMS_PER_PAGE = 10;
    const FIRST_PAGE = 0;

    /**
     * Action for displaying search results for the ajaxed design
     * Displays only the first page (page=0)
     *
     */
    public function searchAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $page = self::FIRST_PAGE;
            $articlesPerPage = (int) $request->request->get('articles_per_page');
            $searchText= (string) $request->request->get('SearchText');
            $page ++;
            $resultsSet= $this->getItemsOfPage($searchText, $page, $articlesPerPage);


            return $this->render('ShopManagementBundle:Search:Search.html.twig', array(
                'entities' => $resultsSet['entities'],
                'number_of_pages'=> $resultsSet['number_of_pages'],
                'countOfResults' =>  $resultsSet['countOfResults'],
                'searchText'=> $searchText
            ));
        }
        else return new Response('Not XMLHttpRequest');
    }

    /**
     * Action for displaying search results for a specific page for the ajaxed design
     *
     *
     */
    public function pageOfSearchAction(Request $request, $searchText)
    {
        if($request->isXmlHttpRequest())
        {
            $page = (int)$request->request->get('page');
            $articlesPerPage = (int)$request->request->get('articles_per_page');

            $page++;
            return $this->render('ShopManagementBundle::items.html.twig', array(
                'entities' =>  $this->getItemsOfPage($searchText, $page, $articlesPerPage)['entities']
            ));
        }
        else return new Response('Not XMLHttpRequest');

    }

    /**
     * Action for displaying search results for the mobile design
     * Displays only the first page (page=0)
     *
     */
    public function mobileSearchAction(Request $request)
    {
        $searchText = (string) $request->request->get('SearchText');
        $page = self::FIRST_PAGE;
        $categories= $this->get('shop_management.category.services')->getAllCategories();

        if(strlen($searchText) > 0)
        {
            $page++;

            $pageOfMobileSearch = array_merge(array(
                'searchText'=> $searchText,
                'categories' => $categories,
                'page' => $page
            ), $this->getItemsOfPage($searchText, $page, self::ITEMS_PER_PAGE));

        }
        else
        {
            $pageOfMobileSearch = array(
                'entities' =>  null,
                'number_of_pages'=> 0,
                'countOfResults' => 0,
                'searchText'=> '',
                'categories' => $categories,
                'page' => $page);
        }


        return $this->render('MobileManagementBundle::mobileSearch.html.twig', $pageOfMobileSearch);
    }

    /**
     * Action for displaying search results for the mobile design for a specific page $page
     *
     *
     */

    public function pageOfMobileSearchAction($searchText, $page)
    {
        $page++;

        $categories= $this->get('shop_management.category.services')->getAllCategories();
        $pageOfMobileSearch = array_merge(array(
                                                'searchText'=> $searchText,
                                                'categories' => $categories,
                                                'page' => $page
                                            ), $this->getItemsOfPage($searchText, $page, self::ITEMS_PER_PAGE));

        return $this->render('MobileManagementBundle::mobileSearch.html.twig', $pageOfMobileSearch);
    }

    /**
     * Getting page of result for a search text
     *
     * @return array
     */
    protected function getItemsOfPage($searchText, $page, $articlesPerPage)
    {
        $finder = $this->get('fos_elastica.finder.search.post');
        $paginator = $finder->findPaginated($searchText);
        $paginator->setMaxPerPage($articlesPerPage);
        $paginator->setCurrentPage($page);

        $resultsSet = $paginator->getCurrentPageResults();

        $countOfResults = $paginator->getNbResults();

        return array(
            'number_of_pages'=> ceil($countOfResults/$articlesPerPage),
            'countOfResults' => $countOfResults,
            'entities' =>  $resultsSet
        );
    }
}
