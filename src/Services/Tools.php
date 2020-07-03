<?php
/**
 * stats service
 * It is a class that containes all functions of tools treatment
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

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * Class Tools
 *
 * @category Service
 * @package  App\Services
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class Tools
{
    private const HEADERS_CHARTS = '0123456789abcdhi';
    /**
     * @var
     */
    public $params;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Tools constructor.
     *
     * @param ParameterBagInterface $params
     * @param LoggerInterface       $logger
     */
    public function __construct(ParameterBagInterface $params, LoggerInterface $logger)
    {
        $this->params = $params;
        $this->logger = $logger;
    }
    /**
     * getRemotData : launch curl remot url and get result
     *
     * @param  string $url : the http url to launch
     * @return array
     */
    public function getRemotData($url, $wss = true)
    {
        try {
            $client = new CurlHttpClient();
            $option = [
                'verify_host' =>0,
                'verify_peer' => 0,
                'http_version' => 1.1,
                'max_redirects' => 10
            ];
            if ($option) {
                $option['headers'] = $this->buildWsseHeader();
            }
            $response = $client->request('GET', $url, $option);
            if ($response) {
                return $response->toArray();
            }
            return [];
        } catch (\Exception $e) {
            $this->logger->error("Error whene connexion to remote server");
            return [];
        }
    }

    /**
     * buildWsseHeader: build http Wsse header
     *
     * @return array [0=>headerConfig,1=> headerContentType]
     */
    public function buildWsseHeader()
    {
        // get Parameters from symfony ParameterBag
        try {
            $username = $this->params->get('API_USERNAME');
            $password = $this->params->get('API_PASSWORD');
        } catch (ParameterNotFoundException $e) {
            $this->logger->error("Error get parameters API_USERNAME,API_PASSWORD not found in .env file");
            return [];
        }

        if (empty($username)) {
            $this->logger->error("Error get parameters API_USERNAME is empty in .env file");
            return [];
        }

        if (empty($password)) {
            $this->logger->error("Error get parameters API_PASSWORD is empty in .env file");
            return [];
        }

        // Initialisation of the nonce
        $nonce = '';
        // Making the nonce and the encoded nonce
        for ($i = 0; $i < 32; $i++) {
            $nonce .= self::HEADERS_CHARTS[rand(0, 15)];
        }
        $nonce64 = base64_encode($nonce);
        // Getting the date at the right format (e.g. YYYY-MM-DDTHH:MM:SSZ)
        $date = substr(gmdate('c'), 0, 19) . "Z";
        // Getting the password digest
        $digest = base64_encode(sha1($nonce . $date . $password, true));
        return [
            sprintf('X-WSSE: UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"', $username, $digest, $nonce64, $date),
            'Content-Type: application/json'
        ];
    }

    /**
     * array_map_assoc : apply treatment to array keys and values
     *
     * @param  callable $f
     * @param  array    $a
     * @return array
     */
    public function array_map_assoc(callable $f, array $a)
    {
        return array_column(array_map($f, array_keys($a), $a), 1, 0);
    }

    /**
     * getUsdCurrencyRates : get currency rate for base
     *
     * @param  string $base
     * @return array
     */
    public function getCurrencyRates(string $base = 'USD'):array
    {
        $api_convert_mony = $this->params->get('AMOUNT_CONVERTER_API');
        if (empty($api_convert_mony)) {
            $this->logger->error("Error get parameters AMOUNT_CONVERTER_API is empty in .env file");
            return [];
        }
        // launch api for get currency rate
        $usdConvertMony = $this->getRemotData($api_convert_mony."?base=$base", false);
        $usdConvertMony['rates'] = $this->array_map_assoc(
            function ($key, $val) {
                return [strtoupper($key),$val];
            }, $usdConvertMony['rates']
        );
        return $usdConvertMony;
    }
}
