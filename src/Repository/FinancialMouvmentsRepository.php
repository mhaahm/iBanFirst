<?php
/**
 * FinancialMouvments Repository:
 * It is a class that contains all the data extraction functions
 *
 * PHP version 7.2
 *
 * @category Repository
 * @package  App\Repository
 * @author   MHA <moham.hassen@gmail.com
 * @license  http://localhost/ test
 * @link     http://localhost/
 */

namespace App\Repository;

use App\Entity\Amount;
use App\Entity\Wallet;
use App\Entity\FinancialMovements;
use App\Services\Tools;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class FinancialMouvmentsRepository
 *
 * @category Repository
 * @package  App\Repository
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class FinancialMouvmentsRepository
{

    /**
     * @var string  
     */
    private $uniqueCurrency = 'USD';
    /**
     * @var Tools
     */
    private $tools;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * FinancialMouvmentsRepository constructor.
     *
     * @param Tools $tools
     * @param ParameterBagInterface $parameterBag
     * @param LoggerInterface $logger
     * @param WalletRepository $repository
     */
    public function __construct(Tools $tools, ParameterBagInterface $parameterBag, LoggerInterface $logger, WalletRepository $repository)
    {
        $this->tools = $tools;
        $this->parameterBag = $parameterBag;
        $this->logger = $logger;
        $this->walletRepository = $repository;
        $this->uniqueCurrency = $this->parameterBag->get('UNIQUE_CURRENCY');
    }

    /**
     * findAll: find all fiancial mouvment
     *
     * @return array
     */
    public function findAll(): array
    {
        // get api base url from config file
        $base_api_url = $this->parameterBag->get('BASE_API_URL');
        // launch request to remot api server for extract financialMovements
        $financial_mouvements = $this->tools->getRemotData($base_api_url . 'financialMovements/');
        if (!isset($financial_mouvements['financialMovements']) or !is_array($financial_mouvements['financialMovements'])) {
            $this->logger->error("No financialMovements data returned by api ");
            return [];
        }
        $currencysRate = $this->tools->getCurrencyRates($this->uniqueCurrency);
        $wallets = $this->walletRepository->findAllWithoutFinancialMouvement();
        $financial_mouvements_for_wallet = [];
        // search all mouvment for current wallet
        foreach ($financial_mouvements['financialMovements'] as $mouvment) {
            // create amount object
            $amount = null;
            if (isset($mouvment['amount'])) {
                $amount = (new Amount())
                    ->setValue($mouvment['amount']['value'])
                    ->setCurrency($mouvment['amount']['currency'])
                    ->setUniqValue($currencysRate['rates'][$mouvment['amount']['currency']]??1)
                    ->setUniqCurrecy($this->uniqueCurrency);
            }
            // create financial mouvment object
            $wallet = $this->searchWallet($mouvment['walletId']??null, $wallets);
            $financial_mouvements_for_wallet[] = (new FinancialMovements())
                ->setId($mouvment['id']??null)
                ->setBookingDate(new \DateTime($mouvment['bookingDate']))
                ->setValueDate(new \DateTime($mouvment['valueDate']))
                ->setDescription($mouvment['description']??null)
                ->setWallet($wallet)
                ->setAmount($amount);
        }
        unset($wallets);
        return $financial_mouvements_for_wallet;
    }

    /**
     * searchWallet : search wallet for single financial movment
     *
     * @param  null|string $id
     * @param  array       $wallets
     * @return Wallet|null
     */
    private function searchWallet(?string  $id, array $wallets):?Wallet
    {
        foreach ($wallets as $wallet) {
            if (strtolower($id) == strtolower($wallet->getId())) {
                return $wallet;
            }
        }
        return null;
    }

    /**
     * findMouvmentByWalletId : search financial movement for wallet with id=$id
     *
     * @param  string $id
     * @return array
     */
    public function findMouvmentByWalletId(string $id):array
    {
        $mouvments = [];
        foreach ($this->findAll() as $mouvment) {
            // if wallet is not null and the id of the wallet equal $id
            if (!is_null($mouvment->getWallet()) && strtolower($mouvment->getWallet()->getId()) == strtolower($id)) {
                $mouvments[] = $mouvment;
            }
        }
        return $mouvments;
    }
}
