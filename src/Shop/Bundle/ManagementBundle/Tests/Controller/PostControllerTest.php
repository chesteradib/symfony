<?php

namespace Shop\Bundle\ManagementBundle\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase AS WebTestCase;

class PostControllerTest extends WebTestCase
{
    
    
    public function testShowAction()
    {
        $client= static::createClient();

        $fixtures = array('Shop\ManagementBundle\dataFixtures\LoadPostData');
        $fixtures2 = array('[hi]'=>'Shop\ManagementBundle\dataFixtures\LoadPostData');
        echo "hi";
        var_dump($fixtures2['[hi]']);
        echo "hi";
        var_dump($fixtures[0]);
        
        $this->loadFixtures($fixtures);
        $articles = LoadArticleData::$articles;
        $article = array_pop($articles);
        
        $id=1;
        $uri= $this->getUrl('post_show', array('id' => $article->getId()));
        
        $crawler= $client->request('GET',$uri);
        var_dump($uri);
        var_dump($client->getResponse()->getContent());
        
        $this->assertEquals(200,$client->getResponse()->getStatusCode() );
        $this->assertTrue($client->getResponse()->isSuccessful());
        
    } 
        

   
}