<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 6/29/2020
 * Time: 22:16
 */
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class WalletsRepositoryTest   extends WebTestCase
{



    public function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get('wallet_repository');
    }

    public function testFindAll()
    {
        $this->assertTrue(count($this->repository->findAll()) > 0 , "The wallets API not return data");
    }

    public function testfindAllWithoutFinancialMouvement()
    {
        $this->assertTrue(count($this->repository->findAllWithoutFinancialMouvement()) > 0 , "The wallets API not return data by function findAllWithoutFinancialMouvement");
    }

    public function testValidateWallets()
    {
        $wallets = $this->repository->findAll();
        $this->assertInstanceOf(\App\Entity\Wallet::class,$wallets[0] , "The wallets API not return data");
    }

    public function testValidatfindAllWithoutFinancialMouvement()
    {
        $this->assertTrue(count($this->repository->findAllWithoutFinancialMouvement()) > 0 , "The wallets API not return data by function findAllWithoutFinancialMouvement");
    }


}