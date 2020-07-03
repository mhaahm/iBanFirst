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
use App\Services\Tools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WalletsController
 *
 * @category Controller
 * @package  App\Controller
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class WalletsController extends AbstractController
{

    /**
     * @var Tools
     */
    private $tools;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * WalletsController constructor.
     *
     * @param Tools                 $tools
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(Tools $tools, ParameterBagInterface $parameterBag)
    {
        $this->tools = $tools;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Index : Controller action of home page
     *
     * @param WalletRepository $repository
     * @Route("/wallets", name="wallets")
     */
    public function index(WalletRepository $repository)
    {
        $wallets = $repository->findAll();


        return $this->render(
            'wallets/index.html.twig',
            compact('wallets')
        );
    }
}
