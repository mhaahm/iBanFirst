<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 7/2/2020
 * Time: 22:48
 */

namespace App\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ToolsTest extends WebTestCase
{
    /** @var \App\Services\Tools $tools */
    private $tools;

    public function setUp()
    {
        self::bootKernel();
        $this->tools = self::$container->get('tools_service');
    }

    public function testGetRemotData()
    {
        $base_api_url = self::$container->getParameter('BASE_API_URL');
        $data = $this->tools->getRemotData($base_api_url. 'wallets/');
        $this->assertTrue(count($data) > 0);
    }

    public function testGetRemotDataWithNonValidUrl()
    {
        $base_api_url = self::$container->getParameter('BASE_API_URL');
        $data = $this->tools->getRemotData($base_api_url. 'walletsNonValid/');
        $this->assertTrue(count($data) == 0);
    }

    public function testBuildWsseHeader()
    {
        $header = $this->tools->buildWsseHeader();
        $this->assertTrue(count($header) > 0,"The header is not valid");
        $this->assertRegExp("/^X-WSSE: UsernameToken Username/",$header[0],"The header content is not valid");
        $this->assertRegExp("/^Content-Type: application\/json$/",$header[1],"The header content is not valid");
    }

    public function testGetCurrencyRates()
    {
        $currencys = $this->tools->getCurrencyRates();
        dump($currencys);
        $this->assertTrue(count($currencys) > 0 , "Currency not valid");

    }


}