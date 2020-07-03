<?php
/**
 * twig extension
 * It is a class that containes all functions of twig treatment
 *
 * PHP version 7.2
 *
 * @category service
 * @package  App\Services
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */

namespace App\Twig;

use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Symfony\Component\Intl\Currencies;
use Twig\TwigFunction;
use Twig\TwigFilter;

/**
 * Class AppExtension
 *
 * @category Extension
 * @package  App\Twig
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class AppExtension extends AbstractExtension
{

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * AppExtension constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getFilters():array
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice'])
        ];
    }

    /**
     * @return array
     */
    public function getFunctions():array
    {
        return [
            new TwigFunction('uniqueCurrency', [$this, 'uniqCurrency']),
        ];
    }

    /**
     * formatPrice format price number
     *
     * @param  float  $number
     * @param  int    $decimals
     * @param  string $decPoint
     * @param  string $thousandsSep
     * @return string
     */
    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ' '):string
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        return $price;
    }

    /**
     * @return null|string
     */
    public function uniqCurrency():?string
    {
        $code = $this->params->get('UNIQUE_CURRENCY');
        return Currencies::getSymbol($code);
    }
}
