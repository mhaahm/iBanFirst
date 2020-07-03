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

class FinancialMouvmentsControllerTest extends WebTestCase
{

    public function testFinancialMouvmentResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/financial/mouvement');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(),"Error when access financial mouvement page");
    }


    public function testFinancialMouvmentContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/financial/mouvement');
        $this->assertEquals(2,$crawler->filter('a[href="/wallets"]')->count());
        $this->assertGreaterThan(0,$crawler->filter('thead')->filter('tr')->count());
    }
}