<?php
/**
 * stats service
 * It is a class that containes all functions of dashboard treatment
 *
 * PHP version 7.2
 *
 * @category service
 * @package  App\Services
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */

namespace App\Services;

use App\Entity\FinancialMovements;
use App\Entity\Wallet;
use App\Repository\FinancialMouvmentsRepository;
use App\Repository\WalletRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class StatsServices
 *
 * @category Service
 * @package  App\Services
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class StatsServices
{

    /**
     * @var FinancialMouvmentsRepository
     */
    private $financialRepository;
    /**
     * @var Tools
     */
    private $tools;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;
    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     *
     * StatsServices constructor.
     * @param WalletRepository $walletRepository
     * @param FinancialMouvmentsRepository $FinancialRepository
     * @param Tools $tools
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(WalletRepository $walletRepository, FinancialMouvmentsRepository $FinancialRepository, Tools $tools, ParameterBagInterface $parameterBag)
    {
        $this->financialRepository = $FinancialRepository;
        $this->tools = $tools;
        $this->parameterBag = $parameterBag;
        $this->walletRepository = $walletRepository;
    }

    /**
     * getStats : build stats consolidation data
     *
     * @return array
     */
    public function getStats():array
    {
        // default values
        $stats = [
            'total_booking' => 0,
            'total_value' => 0,
            'total_mouvment' => 0,
            'amount_booking_by_date' => [],
            'value_amount_by_date' => [],
            'mouvment_amount_by_date' => [],
            'value_nb_by_date' => [],

        ];
        $wallets = $this->walletRepository->findAll();
        if (!count($wallets)) {
            return [];
        }
        /**
         * @var Wallet $wallet
         */
        foreach ($wallets as $wallet) {
            $stats['total_booking'] += $wallet->getBookingAmount()->getUniqValue();
            $date = date('Y-m', $wallet->getDateLastFinancialMovement()->getTimestamp());
            $year = date('Y', $wallet->getDateLastFinancialMovement()->getTimestamp());
            // initialisation
            if (!isset($stats['amount_booking_by_date'][$date])) {
                $stats['amount_booking_by_date'][$date]  = 0;
            }
            if (!isset($stats['value_amount_by_date'][$date])) {
                $stats['value_amount_by_date'][$date]  = 0;
            }
            if (!isset($stats['mouvment_amount_by_date'][$date])) {
                $stats['mouvment_amount_by_date'][$date]  = 0;
            }
            if (!isset($stats['value_nb_by_date'][$year])) {
                $stats['value_nb_by_date'][$year]  = 0;
            }
            $stats['amount_booking_by_date'][$date] += $wallet->getBookingAmount()->getUniqValue();
            $stats['value_amount_by_date'][$date] += $wallet->getValueAmount()->getUniqValue();
            $stats['total_value'] += $wallet->getValueAmount()->getUniqValue();
            /**
             * @var FinancialMovements $mouvment
             */
            foreach ($wallet->getFinancialMouvements() as $mouvment) {
                $stats['total_mouvment']+=$mouvment->getAmount()->getUniqValue();
                $stats['mouvment_amount_by_date'][$date]+=$mouvment->getAmount()->getUniqValue();
                $stats['value_nb_by_date'][$year]++;
            }
        }
        // sorte array for graphs
        ksort($stats['amount_booking_by_date']);
        ksort($stats['value_amount_by_date']);
        ksort($stats['mouvment_amount_by_date']);
        ksort($stats['value_nb_by_date']);
        return $stats;
    }
}
