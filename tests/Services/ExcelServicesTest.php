<?php
/**
 * Created by PhpStorm.
 * User: Dell_PC
 * Date: 7/4/2020
 * Time: 07:19
 */

namespace App\Tests\Services;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelServicesTest extends WebTestCase
{

   public function setUp()
   {
       self::bootKernel();
       $this->excelService = self::$container->get("excel_services");
   }

   public function testBuildHeader()
   {
       $spreadsheet = new Spreadsheet();
       $sheet = $spreadsheet->getActiveSheet();
       $sheet->setTitle("iBanFirst Wallets");
       $this->excelService->buildSheetHeader($sheet);
       $this->assertTrue(count($sheet->toArray())>0);
   }
}