<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 6/28/2020
 * Time: 14:38
 */

namespace App\Tests\Controller;

use App\Controller\HomeController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{

    public function testHomeResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(),"Error when access home page");
    }


    public function testHomeContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(1,$crawler->filter('div[class="page-header"]')->count(),"Error when access home page (div with class page-header not exists)");
        $this->assertEquals(1,$crawler->filter('div[class^="text-secondary-d3"]')->count(),"Error when access home page (div with class text-secondary-d3 not exists)");
        $this->assertEquals(4,$crawler->filter('canvas')->count(),"Error when access home page (canvas not exists)");
    }



}