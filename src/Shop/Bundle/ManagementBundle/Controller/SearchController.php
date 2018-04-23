<?php

namespace Shop\Bundle\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SearchController extends Controller
{
    const ITEMS_PER_PAGE = 10;

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


    public function mobileSearchAction(Request $request)
    {
        $SearchText = (string)$request->request->get('SearchText');

        $categories= $this->get('shop_management.category.services')->getAllCategories();

        if(strlen($SearchText) > 0)
        {
            $finder = $this->container->get('fos_elastica.finder.search.post');

            $paginator = $finder->findPaginated($SearchText);

            $paginator->setMaxPerPage(self::ITEMS_PER_PAGE);
            $countOfResults = $paginator->getNbResults();
            $resultsSet= $paginator->getCurrentPageResults();



            $firstPart = array(
                'entities' =>  $resultsSet,
                'number_of_pages'=> ceil($countOfResults/self::ITEMS_PER_PAGE),
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


        return $this->render('MobileManagementBundle::mobileSearch.html.twig', $firstPart);
    }

    public function pageOfMobileSearchAction($SearchText, $page)
    {
        $page++;

        $categories= $this->get('shop_management.category.services')->getAllCategories();
        $pageOfMobileSearch = array_merge(array(
                                                'searchText'=> $SearchText,
                                                'categories' => $categories,
                                                'page' => $page
                                            ), $this->getItemsOfPage($SearchText, $page));

        return $this->render('MobileManagementBundle::mobileSearch.html.twig', $pageOfMobileSearch);
    }

    /**
     * Getting page of result for a search text
     *
     * @return array
     */
    protected function getItemsOfPage($SearchText, $page)
    {
        $finder = $this->get('fos_elastica.finder.search.post');
        $paginator = $finder->findPaginated($SearchText);
        $paginator->setMaxPerPage(self::ITEMS_PER_PAGE);
        $paginator->setCurrentPage($page);

        $resultsSet = $paginator->getCurrentPageResults();

        $countOfResults = $paginator->getNbResults();

        return array(
            'number_of_pages'=> ceil($countOfResults/self::ITEMS_PER_PAGE),
            'countOfResults' => $countOfResults,
            'entities' =>  $resultsSet
        );
    }



}
