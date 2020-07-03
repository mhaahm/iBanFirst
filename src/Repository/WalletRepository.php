<?php
/**
 * Wallet Repository :
  It is a class that contains all the data extraction functions
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
 * Class WalletRepository
 *
 * @category Repository
 * @package  App\Repository
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class WalletRepository
{
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
     * WalletRepository constructor.
     *
     * @param Tools $tools
     * @param ParameterBagInterface $parameterBag
     * @param LoggerInterface $logger
     */
    public function __construct(Tools $tools, ParameterBagInterface $parameterBag, LoggerInterface $logger)
    {
        $this->tools = $tools;
        $this->parameterBag = $parameterBag;
        $this->logger = $logger;
        $this->uniqueCurrency = $this->parameterBag->get('UNIQUE_CURRENCY');
    }

    /**
     * findAll: find all wallets
     *
     * @return array
     */
    public function findAll(): array
    {
        // get api base url from config file
        $base_api_url = $this->parameterBag->get('BASE_API_URL');
        // launch request to remot api server for extract wallets
        $wallets = $this->tools->getRemotData($base_api_url . 'wallets/');
        if (!isset($wallets['wallets']) or !is_array($wallets['wallets'])) {
            $this->logger->error("No wallets data returned by api ");
            return [];
        }
        $currencysRate = $this->tools->getCurrencyRates($this->uniqueCurrency);
        // launch request to remot api server for extract financialMovements
        $financialMouvmemnts = $this->tools->getRemotData($base_api_url . 'financialMovements/');
        $wallets_to_return = [];
        foreach ($wallets['wallets'] as $walet) {
            $date_last_mouvment = new \DateTime($walet['dateLastFinancialMovement']);
            // create the valueAmount object
            $valueAmount = (new Amount())
                ->setCurrency($walet['valueAmount']['currency'])
                ->setValue($walet['valueAmount']['value'])
                ->setUniqValue($currencysRate['rates'][$walet['valueAmount']['currency']]??1)
                ->setUniqCurrecy('USD');
            // create the bookingAmount object
            $bookingAmount = (new Amount())
                ->setCurrency($walet['bookingAmount']['currency'])
                ->setValue($walet['bookingAmount']['value'])
                ->setUniqValue($currencysRate['rates'][$walet['bookingAmount']['currency']]??1)
                ->setUniqCurrecy($this->uniqueCurrency);
            // create the wallet object
            $wallet_obj = (new Wallet())
                ->setId($walet['id'])
                ->setCurrency($walet['currency'])
                ->setTag($walet['tag'])
                ->setDateLastFinancialMovement($date_last_mouvment)
                ->setBookingAmount($bookingAmount)
                ->setValueAmount($valueAmount);
            // get the wallet financial mouvment
            $walletFinancialMouvmemnts = $this->getFinancialMouvmentForWallet($walet['id'], $financialMouvmemnts, $currencysRate);
            //  add wallet financial mouvment to current wallet
            foreach ($walletFinancialMouvmemnts as $walletFinancialMouvmemnt) {
                $wallet_obj->addFinancialMouvements($walletFinancialMouvmemnt);
            }
            $wallets_to_return[] = $wallet_obj;
            unset($wallet_obj);
            unset($walletFinancialMouvmemnts);
        }
        // sorte the wallets by nb mouvments
        uasort(
            $wallets_to_return, function ($a, $b) {
                $v1 = count($a->getFinancialMouvements());
                $v2 = count($b->getFinancialMouvements());
                return $v2 - $v1;
            }
        );
        return $wallets_to_return;
    }

    /**
     * getFinancialMouvmentForWallet : search and return all finantial mouvment for specific wallet
     *
     * @param  string $wallet_id
     * @param  array  $financial_mouvements
     * @return array
     */
    private function getFinancialMouvmentForWallet(string $wallet_id, array $financial_mouvements, $currencysRate = []): array
    {
        if (!isset($financial_mouvements['financialMovements']) or !is_array($financial_mouvements['financialMovements'])) {
            $this->logger->error("No financialMovements data returned by api ");
            return [];
        }

        if (!count($currencysRate)) {
            $currencysRate = $this->tools->getCurrencyRates($this->uniqueCurrency);
        }
        $financial_mouvements_for_wallet = [];
        // search all mouvment for current wallet
        foreach ($financial_mouvements['financialMovements'] as $mouvment) {
            if (isset($mouvment['walletId']) && strtolower($mouvment['walletId']) == strtolower($wallet_id)) {
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
                $financial_mouvements_for_wallet[] = (new FinancialMovements())
                    ->setId($mouvment['id']??null)
                    ->setBookingDate(new \DateTime($mouvment['bookingDate']))
                    ->setValueDate(new \DateTime($mouvment['valueDate']))
                    ->setDescription($mouvment['description']??null)
                    ->setAmount($amount);
            }
        }
        return $financial_mouvements_for_wallet;
    }

    /**
     * findAll: find all wallets
     *
     * @return array
     */
    public function findAllWithoutFinancialMouvement(): array
    {
        // get api base url from config file
        $base_api_url = $this->parameterBag->get('BASE_API_URL');
        // launch request to remot api server for extract wallets
        $wallets = $this->tools->getRemotData($base_api_url . 'wallets/');
        if (!isset($wallets['wallets']) or !is_array($wallets['wallets'])) {
            $this->logger->error("No wallets data returned by api ");
            return [];
        }
        $currencysRate = $this->tools->getCurrencyRates($this->uniqueCurrency);
        $wallets_to_return = [];
        foreach ($wallets['wallets'] as $walet) {
            $date_last_mouvment = new \DateTime($walet['dateLastFinancialMovement']);
            // create the valueAmount object
            $valueAmount = (new Amount())
                ->setCurrency($walet['valueAmount']['currency'])
                ->setValue($walet['valueAmount']['value'])
                ->setUniqValue($currencysRate['rates'][$walet['valueAmount']['currency']]??1)
                ->setUniqCurrecy($this->uniqueCurrency);
            // create the bookingAmount object
            $bookingAmount = (new Amount())
                ->setCurrency($walet['bookingAmount']['currency'])
                ->setValue($walet['bookingAmount']['value'])
                ->setUniqValue($currencysRate['rates'][$walet['bookingAmount']['currency']]??1)
                ->setUniqCurrecy($this->uniqueCurrency);
            // create the wallet object
            $wallet_obj = (new Wallet())
                ->setId($walet['id'])
                ->setCurrency($walet['currency'])
                ->setTag($walet['tag'])
                ->setDateLastFinancialMovement($date_last_mouvment)
                ->setBookingAmount($bookingAmount)
                ->setValueAmount($valueAmount);
            $wallets_to_return[] = $wallet_obj;
            unset($wallet_obj);
        }
        return $wallets_to_return;
    }
}
