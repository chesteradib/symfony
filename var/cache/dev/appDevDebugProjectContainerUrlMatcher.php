<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not__profiler_home;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', '_profiler_home'));
                    }

                    return $ret;
                }
                not__profiler_home:

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler_open_file
                if ('/_profiler/open' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:openAction',  '_route' => '_profiler_open_file',);
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        elseif (0 === strpos($pathinfo, '/m')) {
            // mobile_item_show
            if (0 === strpos($pathinfo, '/m/item') && preg_match('#^/m/item/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_item_show')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\ItemController::mobileShowAction',));
            }

            // mobile_item_new
            if ('/m/new' === $pathinfo) {
                return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\ItemController::mobileNewAction',  '_route' => 'mobile_item_new',);
            }

            // mobile_item_creates
            if ('/m/creates' === $pathinfo) {
                return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\ItemController::mobileCreatesAction',  '_route' => 'mobile_item_creates',);
            }

            // mobile_item_edits
            if (0 === strpos($pathinfo, '/m/edits') && preg_match('#^/m/edits/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_item_edits')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\ItemController::mobileEditsAction',));
            }

            // mobile_item_updates
            if (0 === strpos($pathinfo, '/m/updates') && preg_match('#^/m/updates/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_item_updates')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\ItemController::mobileUpdatesAction',));
            }

            // mobile_item_deletes
            if (0 === strpos($pathinfo, '/m/deletes') && preg_match('#^/m/deletes/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_item_deletes')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\ItemController::mobileDeletesAction',));
            }

            // mobile_shop_show
            if (preg_match('#^/m/(?P<shop_id>[^/]++)/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_shop_show')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileShopController::displayMobileShopAction',));
            }

            // mobile_shop_from_my_network_show
            if (preg_match('#^/m/(?P<shop_id>[^/]++)/g/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_shop_from_my_network_show')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileShopController::displayMobileShopFromMyNetworkAction',));
            }

            // mobile_shop_from_my_market_show
            if (preg_match('#^/m/(?P<shop_id>[^/]++)/g/d/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_shop_from_my_market_show')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileShopController::displayMobileShopFromMyMarketAction',));
            }

            if (0 === strpos($pathinfo, '/m/my')) {
                // mobile_my_shop
                if (0 === strpos($pathinfo, '/m/my/shop/g') && preg_match('#^/m/my/shop/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_my_shop')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileMyShopController::displayMobileMyShopAction',));
                }

                // mobile_my_market
                if (0 === strpos($pathinfo, '/m/my/market/g') && preg_match('#^/m/my/market/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_my_market')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileMyMarketController::displayMobileMyMarketAction',));
                }

                // mobile_my_inbox
                if (0 === strpos($pathinfo, '/m/my/inbox/g') && preg_match('#^/m/my/inbox/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_my_inbox')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileMessagingController::mobileMyInboxAction',));
                }

                // mobile_index
                if (0 === strpos($pathinfo, '/m/my/index/g') && preg_match('#^/m/my/index/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_index')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileIndexController::mobileIndexAction',));
                }

                // mobile_admin
                if (0 === strpos($pathinfo, '/m/my/admin/g') && preg_match('#^/m/my/admin/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_admin')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileAdminController::mobileAdminAction',));
                }

                // mobile_all_my_network
                if (0 === strpos($pathinfo, '/m/my/network/g') && preg_match('#^/m/my/network/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_all_my_network')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileFollowController::mobileAllMyNetworkAction',));
                }

                // mobile_all_my_followeds
                if (0 === strpos($pathinfo, '/m/my/followeds/g') && preg_match('#^/m/my/followeds/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_all_my_followeds')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileFollowController::mobileAllMyFollowedsAction',));
                }

            }

            // mobile_discussion
            if (0 === strpos($pathinfo, '/m/mobile_discussion') && preg_match('#^/m/mobile_discussion/(?P<post_id>[^/]++)/(?P<shop_id>[^/]++)/?$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_discussion')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileMessagingController::getDiscussionAboutPostWithAction',));
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_mobile_discussion;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'mobile_discussion'));
                }

                return $ret;
            }
            not_mobile_discussion:

            // mobile_fos_user_security_login
            if ('/m/login' === $pathinfo) {
                return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileSecurityController::loginAction',  '_route' => 'mobile_fos_user_security_login',);
            }

            if (0 === strpos($pathinfo, '/m/register')) {
                // mobile_fos_user_registration_register
                if ('/m/register' === $pathinfo) {
                    return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileRegistrationController::mobileRegisterAction',  '_route' => 'mobile_fos_user_registration_register',);
                }

                // mobile_fos_user_registration_check_email
                if ('/m/register/check-email' === $pathinfo) {
                    return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileRegistrationController::mobileCheckEmailAction',  '_route' => 'mobile_fos_user_registration_check_email',);
                }

                if (0 === strpos($pathinfo, '/m/register/confirm')) {
                    // mobile_fos_user_registration_confirm
                    if (preg_match('#^/m/register/confirm/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_fos_user_registration_confirm')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileRegistrationController::mobileConfirmAction',));
                    }

                    // mobile_fos_user_registration_confirmed
                    if ('/m/register/confirmed' === $pathinfo) {
                        return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileRegistrationController::mobileConfirmedAction',  '_route' => 'mobile_fos_user_registration_confirmed',);
                    }

                }

            }

            elseif (0 === strpos($pathinfo, '/m/resetting')) {
                // mobile_fos_user_resetting_request
                if ('/m/resetting/request' === $pathinfo) {
                    return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileResettingController::requestAction',  '_route' => 'mobile_fos_user_resetting_request',);
                }

                // mobile_fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/m/resetting/reset') && preg_match('#^/m/resetting/reset/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_fos_user_resetting_reset')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileResettingController::resetAction',));
                }

                // mobile_fos_user_resetting_send_email
                if ('/m/resetting/send-email' === $pathinfo) {
                    return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileResettingController::sendEmailAction',  '_route' => 'mobile_fos_user_resetting_send_email',);
                }

                // mobile_fos_user_resetting_check_email
                if ('/m/resetting/check-email' === $pathinfo) {
                    return array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileResettingController::checkEmailAction',  '_route' => 'mobile_fos_user_resetting_check_email',);
                }

            }

            elseif (0 === strpos($pathinfo, '/m/search')) {
                // mobile_page_of_search
                if (preg_match('#^/m/search/(?P<SearchText>[^/]++)/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_page_of_search')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileAdminController::pageOfSearchAction',));
                }

                // mobile_site_search
                if ('/m/search' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileAdminController::searchAction',  '_route' => 'mobile_site_search',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_mobile_site_search;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'mobile_site_search'));
                    }

                    return $ret;
                }
                not_mobile_site_search:

            }

            // mobile_category
            if (0 === strpos($pathinfo, '/m/category') && preg_match('#^/m/category/(?P<categoryId>[^/]++)/g/(?P<page>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobile_category')), array (  '_controller' => 'Mobile\\Bundle\\ManagementBundle\\Controller\\MobileCategoryController::mobileCategoryAction',));
            }

        }

        // global_item_show
        if (0 === strpos($pathinfo, '/g/item') && preg_match('#^/g/item/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'global_item_show')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::globalShowAction',));
        }

        // post_show
        if (preg_match('#^/(?P<id>[^/]++)/show$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_show')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::showAction',));
        }

        // post_new
        if ('/new' === $pathinfo) {
            return array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::newAction',  '_route' => 'post_new',);
        }

        // post_edits
        if (preg_match('#^/(?P<id>[^/]++)/edits$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_edits')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::editsAction',));
        }

        // post_creates
        if ('/creates' === $pathinfo) {
            return array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::createsAction',  '_route' => 'post_creates',);
        }

        // post_updates
        if (preg_match('#^/(?P<id>[^/]++)/updates$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_updates')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::updatesAction',));
        }

        // post_deletes
        if (preg_match('#^/(?P<id>[^/]++)/deletes$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_deletes')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::deletesAction',));
        }

        // post_bought
        if (preg_match('#^/(?P<post_id>[^/]++)/bought$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_bought')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::boughtAction',));
        }

        if (0 === strpos($pathinfo, '/my_market')) {
            // get_my_market_posts
            if ('/my_market_posts' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\MarketController::displayMarketPostsAction',  '_route' => 'get_my_market_posts',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_get_my_market_posts;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_my_market_posts'));
                }

                return $ret;
            }
            not_get_my_market_posts:

            // get_my_market
            if ('/my_market' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\MarketController::displayMyMarketAction',  '_route' => 'get_my_market',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_get_my_market;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_my_market'));
                }

                return $ret;
            }
            not_get_my_market:

            // get_my_market_dialog
            if ('/my_market_dialog' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\MarketController::myMarketDialogAction',  '_route' => 'get_my_market_dialog',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_get_my_market_dialog;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_my_market_dialog'));
                }

                return $ret;
            }
            not_get_my_market_dialog:

        }

        // get_posts
        if (preg_match('#^/(?P<shop_id>[^/]++)/posts/?$#sD', $pathinfo, $matches)) {
            $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'get_posts')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\ShopController::displayPostsAction',));
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_get_posts;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_posts'));
            }

            return $ret;
        }
        not_get_posts:

        // get_my_shop
        if ('/my_shop' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\MyShopController::displayMyShopAction',  '_route' => 'get_my_shop',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_get_my_shop;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_my_shop'));
            }

            return $ret;
        }
        not_get_my_shop:

        // get_shop
        if (0 === strpos($pathinfo, '/shop') && preg_match('#^/shop/(?P<shop_id>[^/]++)/?$#sD', $pathinfo, $matches)) {
            $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'get_shop')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\ShopController::displayShopAction',));
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_get_shop;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_shop'));
            }

            return $ret;
        }
        not_get_shop:

        // image_uploads
        if ('/image_uploads' === $pathinfo) {
            return array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\ImageController::uploadsAction',  '_route' => 'image_uploads',);
        }

        // image_deletes
        if ('/image_deletes' === $pathinfo) {
            return array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\ImageController::deletesAction',  '_route' => 'image_deletes',);
        }

        // show_shop
        if (preg_match('#^/(?P<shop_id>[^/]++)/external$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'show_shop')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\ExternalController::showShopAction',));
        }

        // show_category
        if ('/category' === $pathinfo) {
            return array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\CategoryController::getArticlesOfCategoryAction',  '_route' => 'show_category',);
        }

        // page_of_show_category
        if (0 === strpos($pathinfo, '/page_of_category') && preg_match('#^/page_of_category/(?P<category_id>[^/]++)/?$#sD', $pathinfo, $matches)) {
            $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'page_of_show_category')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\CategoryController::getPageOfArticlesOfCategoryAction',));
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_page_of_show_category;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'page_of_show_category'));
            }

            return $ret;
        }
        not_page_of_show_category:

        // post_retweet
        if (preg_match('#^/(?P<post_id>[^/]++)/retweet$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_retweet')), array (  '_controller' => 'Shop\\Bundle\\ManagementBundle\\Controller\\PostController::retweetAction',));
        }

        // get_site_search_posts
        if (preg_match('#^/(?P<search_text>[^/]++)/site/search/?$#sD', $pathinfo, $matches)) {
            $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'get_site_search_posts')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::pageOfSearchAction',));
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_get_site_search_posts;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'get_site_search_posts'));
            }

            return $ret;
        }
        not_get_site_search_posts:

        // site_search
        if ('/site/search' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::searchAction',  '_route' => 'site_search',);
        }

        if (0 === strpos($pathinfo, '/all_')) {
            if (0 === strpos($pathinfo, '/all_jawla')) {
                // all_jawla
                if ('/all_jawla' === $pathinfo) {
                    return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::allJawlaAction',  '_route' => 'all_jawla',);
                }

                // all_jawla_items
                if ('/all_jawla_items' === $pathinfo) {
                    return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::allJawlaItemsAction',  '_route' => 'all_jawla_items',);
                }

            }

            // all_new_posters
            if ('/all_new_posters' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::allNewPostersAction',  '_route' => 'all_new_posters',);
            }

            // all_my_network
            if ('/all_my_network' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::allMyNetworkAction',  '_route' => 'all_my_network',);
            }

            // all_my_followeds
            if ('/all_my_followeds' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::allMyFollowedsAction',  '_route' => 'all_my_followeds',);
            }

        }

        // user_admin_page
        if ('/admin' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::adminAction',  '_route' => 'user_admin_page',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_user_admin_page;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'user_admin_page'));
            }

            return $ret;
        }
        not_user_admin_page:

        if (0 === strpos($pathinfo, '/page_of_')) {
            // page_of_all_new_posters
            if ('/page_of_all_new_posters' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\AdminController::pageOfAllNewPostersAction',  '_route' => 'page_of_all_new_posters',);
            }

            // page_of_all_my_network
            if ('/page_of_all_my_network' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::pageOfAllMyNetworkAction',  '_route' => 'page_of_all_my_network',);
            }

            // page_of_all_my_followeds
            if ('/page_of_my_followeds' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::pageOfAllMyFollowedsAction',  '_route' => 'page_of_all_my_followeds',);
            }

        }

        // non_fos_user_security_login
        if ('/login' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\SecurityController::bigLoginAction',  '_route' => 'non_fos_user_security_login',);
        }

        // last_date
        if ('/last_date' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::lastDateAction',  '_route' => 'last_date',);
        }

        // follow_unfollow_shop
        if (0 === strpos($pathinfo, '/followunfollow') && preg_match('#^/followunfollow/(?P<shop_id>[^/]++)$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'follow_unfollow_shop')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::followUnfollowAction',));
        }

        // follow_seen
        if ('/follow_seen' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::followSeenAction',  '_route' => 'follow_seen',);
        }

        // network_messages
        if ('/network_messages' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\FollowController::networkMessagesAction',  '_route' => 'network_messages',);
        }

        // index
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\IndexController::indexAction',  '_route' => 'index',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_index;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'index'));
            }

            return $ret;
        }
        not_index:

        // mobile
        if ('/mobile' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\IndexController::mobileAction',  '_route' => 'mobile',);
        }

        // add_message
        if (preg_match('#^/(?P<receiver_id>[^/]++)/(?P<post_id>[^/]++)/add_message$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'add_message')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::addMessageAction',));
        }

        // new_message
        if (0 === strpos($pathinfo, '/new_message') && preg_match('#^/new_message/(?P<receiver_id>[^/]++)/(?P<post_id>[^/]++)$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'new_message')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::newMessageAction',));
        }

        // inbox_messages
        if (preg_match('#^/(?P<receiver_id>[^/]++)/inbox_messages$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'inbox_messages')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::inboxMessagesAction',));
        }

        // all_my_inbox
        if ('/all_my_inbox' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::allMyInboxAction',  '_route' => 'all_my_inbox',);
        }

        // page_of_all_my_inbox
        if ('/page_of_all_my_inbox' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::pageOfAllMyInboxAction',  '_route' => 'page_of_all_my_inbox',);
        }

        if (0 === strpos($pathinfo, '/message')) {
            // messages_between_two_users_about_article
            if (0 === strpos($pathinfo, '/messages_between_two_users_about_article') && preg_match('#^/messages_between_two_users_about_article/(?P<sender_id>[^/]++)/(?P<receiver_id>[^/]++)/(?P<post_id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'messages_between_two_users_about_article')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::getMessagesBetweenTwoUsersAboutArticleAction',));
            }

            // messages_seen
            if ('/messages_seen' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::messagesSeenAction',  '_route' => 'messages_seen',);
            }

            // message_seen
            if ('/message_seen' === $pathinfo) {
                return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\MessagesController::messageSeenAction',  '_route' => 'message_seen',);
            }

        }

        // latlngjson
        if ('/latlngjson' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\ProfileController::latLngJsonAction',  '_format' => 'json',  '_route' => 'latlngjson',);
        }

        // update_profile_picture
        if (preg_match('#^/(?P<user_id>[^/]++)/update_profile_picture$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'update_profile_picture')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\ProfileController::updateProfilePictureAction',));
        }

        // delete_profile_picture
        if (preg_match('#^/(?P<img_id>[^/]++)/delete_profile_picture$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_profile_picture')), array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\ProfileController::deleteProfilePictureAction',));
        }

        // deactivate_profile
        if ('/deactivate_profile' === $pathinfo) {
            return array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\ProfileController::deactivateProfileAction',  '_route' => 'deactivate_profile',);
        }

        if (0 === strpos($pathinfo, '/log')) {
            // fos_user_security_login
            if ('/login/login' === $pathinfo) {
                $ret = array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_security_login;
                }

                return $ret;
            }
            not_fos_user_security_login:

            // fos_user_security_check
            if ('/login_check' === $pathinfo) {
                $ret = array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_fos_user_security_check;
                }

                return $ret;
            }
            not_fos_user_security_check:

            // fos_user_security_logout
            if ('/logout' === $pathinfo) {
                $ret = array (  '_controller' => 'Members\\Bundle\\ManagementBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_security_logout;
                }

                return $ret;
            }
            not_fos_user_security_logout:

        }

        elseif (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if ('/profile' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'fos_user.profile.controller:showAction',  '_route' => 'fos_user_profile_show',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_fos_user_profile_show;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fos_user_profile_show'));
                }

                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_profile_show;
                }

                return $ret;
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ('/profile/edit' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.profile.controller:editAction',  '_route' => 'fos_user_profile_edit',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_profile_edit;
                }

                return $ret;
            }
            not_fos_user_profile_edit:

            // fos_user_change_password
            if ('/profile/change-password' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.change_password.controller:changePasswordAction',  '_route' => 'fos_user_change_password',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_change_password;
                }

                return $ret;
            }
            not_fos_user_change_password:

        }

        elseif (0 === strpos($pathinfo, '/register')) {
            // fos_user_registration_register
            if ('/register' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'fos_user.registration.controller:registerAction',  '_route' => 'fos_user_registration_register',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_fos_user_registration_register;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fos_user_registration_register'));
                }

                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_registration_register;
                }

                return $ret;
            }
            not_fos_user_registration_register:

            // fos_user_registration_check_email
            if ('/register/check-email' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.registration.controller:checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_registration_check_email;
                }

                return $ret;
            }
            not_fos_user_registration_check_email:

            if (0 === strpos($pathinfo, '/register/confirm')) {
                // fos_user_registration_confirm
                if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'fos_user.registration.controller:confirmAction',));
                    if (!in_array($canonicalMethod, array('GET'))) {
                        $allow = array_merge($allow, array('GET'));
                        goto not_fos_user_registration_confirm;
                    }

                    return $ret;
                }
                not_fos_user_registration_confirm:

                // fos_user_registration_confirmed
                if ('/register/confirmed' === $pathinfo) {
                    $ret = array (  '_controller' => 'fos_user.registration.controller:confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                    if (!in_array($canonicalMethod, array('GET'))) {
                        $allow = array_merge($allow, array('GET'));
                        goto not_fos_user_registration_confirmed;
                    }

                    return $ret;
                }
                not_fos_user_registration_confirmed:

            }

        }

        elseif (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ('/resetting/request' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.resetting.controller:requestAction',  '_route' => 'fos_user_resetting_request',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_resetting_request;
                }

                return $ret;
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'fos_user.resetting.controller:resetAction',));
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_resetting_reset;
                }

                return $ret;
            }
            not_fos_user_resetting_reset:

            // fos_user_resetting_send_email
            if ('/resetting/send-email' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.resetting.controller:sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_fos_user_resetting_send_email;
                }

                return $ret;
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ('/resetting/check-email' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.resetting.controller:checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_resetting_check_email;
                }

                return $ret;
            }
            not_fos_user_resetting_check_email:

        }

        elseif (0 === strpos($pathinfo, '/media/cache/resolve')) {
            // liip_imagine_filter_runtime
            if (preg_match('#^/media/cache/resolve/(?P<filter>[A-z0-9_-]*)/rc/(?P<hash>[^/]++)/(?P<path>.+)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'liip_imagine_filter_runtime')), array (  '_controller' => 'liip_imagine.controller:filterRuntimeAction',));
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_liip_imagine_filter_runtime;
                }

                return $ret;
            }
            not_liip_imagine_filter_runtime:

            // liip_imagine_filter
            if (preg_match('#^/media/cache/resolve/(?P<filter>[A-z0-9_-]*)/(?P<path>.+)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'liip_imagine_filter')), array (  '_controller' => 'liip_imagine.controller:filterAction',));
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_liip_imagine_filter;
                }

                return $ret;
            }
            not_liip_imagine_filter:

        }

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
