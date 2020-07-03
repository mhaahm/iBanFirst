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

use App\Repository\FinancialMouvmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FinancialMouvementController
 *
 * @category Controller
 * @package  App\Controller
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class FinancialMouvementController extends AbstractController
{
    /**
     * Index : Controller action of home page
     *
     * @param
     * FinancialMouvmentsRepository $financialMouvmentsRepository :
     *   financial mouvment  repository instance
     * @param Request $request :
     *                         request
     *                         instance
     *
     * @Route(
     *     "/financial/mouvement/{walletId}",
     *     name="financial_mouvement",
     *     defaults={"walletId":null}
     * )
     * @return string
     */
    public function index(FinancialMouvmentsRepository $financialMouvmentsRepository, Request $request)
    {
        $wallet_id = $request->get('walletId');
        if ($wallet_id) {
            $financialMouvments = $financialMouvmentsRepository->findMouvmentByWalletId($wallet_id);
        } else {
            $financialMouvments = $financialMouvmentsRepository->findAll();
        }

        return $this->render('financial_mouvement/index.html.twig', compact('financialMouvments'));
    }
}
