<?php
/**
 * Controller
 *
 * PHP version 7.2
 *
 * @category Controller
 * @package  App\Controller
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
namespace App\Controller;

use App\Repository\WalletRepository;
use App\Services\{ExcelService,StatsServices};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class HomeController
 *
 * @category Controller
 * @package  App\Controller
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class HomeController extends AbstractController
{

    /**
     * @var StatsServices
     */
    private $statsServices;
    /**
     * @var WalletRepository
     */
    private $walletRepository;
    /**
     * @var ExcelService
     */
    private $excelService;

    /**
     * HomeController constructor.
     * @param StatsServices $statsServices
     * @param WalletRepository $walletRepository
     * @param ExcelService $excelService
     */
    public function __construct(StatsServices $statsServices, WalletRepository $walletRepository, ExcelService $excelService)
    {
        $this->statsServices = $statsServices;
        $this->walletRepository = $walletRepository;
        $this->excelService = $excelService;
    }

    /**
     * Index : the home action of dashboard page
     *
     * @Route("/", name="home")
     * @return string
     */
    public function index()
    {
        $statsData = $this->statsServices->getStats();
        return $this->render(
            'home/index.html.twig',
            compact('statsData')
        );
    }

    /**
     * ExportExcel : the export excel action
     *
     * @Route("/ExportExcel",name="export_excel")
     * @return string
     */
    public function exportExcel()
    {
        // get all wallets
        $wallets = $this->walletRepository->findAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("iBanFirst Wallets");
        $this->excelService->buildSheetHeader($sheet);
        $this->excelService->buildSheetData($sheet, $wallets);
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'my_first_excel_symfony4.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
