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


}