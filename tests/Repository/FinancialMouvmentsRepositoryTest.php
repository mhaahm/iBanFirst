<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 6/29/2020
 * Time: 22:16
 */
namespace App\Tests\Controller;

use App\Controller\HomeController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\WalletRepository;
class FinancialMouvmentsRepositoryTest   extends WebTestCase
{



    public function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get('financial_repository');
    }

    public function testFindAll()
    {
        $this->assertTrue(count($this->repository->findAll()) > 0 , "The financial Mouvements API not return data");
    }

    public function testValidateFinancialMouvment()
    {
        $financialMouvments = $this->repository->findAll();
        $this->assertInstanceOf(\App\Entity\FinancialMovements::class,$financialMouvments[0] , "The FinancialMouvments API not return valide data");
    }

}