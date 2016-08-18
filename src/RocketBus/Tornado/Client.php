<?php

namespace RocketBus\Tornado;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ConnectException;
use Mockery\CountValidator\Exception;
use RocketBus\Tornado\Type\Config;
use RocketBus\Tornado\Type\GetTravelsRequest;

/**
 * Class Client
 * @package Tornado
 */
class Client
{
    const HTTP_OK = 200;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    const ERROR_CODE_RESERVED_SEAT = '00016';

    const ENDPOINT_SCHEDULE = '/public/ApiFriendly/getTravels';
    const ENDPOINT_BOOKING = '/WSCCVE2/confirmacionVenta';
    const ENDPOINT_SEAT_RESERVATION = '/WSCCVE/confirmacionReservacion';
    const ENDPOINT_SEAT_BLOCK = '/WSCBAS/bloqueaAsiento';
    const ENDPOINT_SEAT_UNBLOCK = '/WSCLAS/desbloqueaAsientos';
    const ENDPOINT_SEAT_AVAILABILITY = '/WSCDISA/disponibilidadAsientos';
    const ENDPOINT_ORIGIN_PLACES = '/public/ApiFriendly/getDepartures';
    const ENDPOINT_DESTINATION_PLACES = '/public/ApiFriendly/getArrivals';

    const FORMAT_DATE = 'Y-m-d';
    const FORMAT_HOUR = 'H:i:s';
    const AT_LEAST_ONE_SEAT = 1;

    /**
     * @var HttpClient
     */
    protected $httpClient;


    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array()
     */
    protected $lastRequest;

    /**
     * @var array()
     */
    protected $lastResponse;

    /**
     * @param Config $config
     * @param HttpClient $httpClient
     */
    public function __construct(
        Config $config,
        HttpClient $httpClient
    ) {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }


    /**
     * @param string $path
     * @param array $data
     * @return array
     * @throws Exception
     * @throws TimeOutException
     * @throws AccessDeniedException
     */
    public function request($path, $data = [])
    {
        try {
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            /** @var \GuzzleHttp\Message\ResponseInterface $response */
            $response = $this->httpClient->post($path, ['body' => $data]);
        } catch (ConnectException $e) {
            throw new TimeOutException();
        }

        $body = $response->json();

        if (isset($body['code'])) {
            if ($body['code']===441) {
                return $body['data'];
            } else {
                throw new Exception($body['msg']);
            }
        } else {
            throw new Exception('ERROR');
        }
    }

    /*
     |-------------------------------------------------------------------------
     | Getters and Setters
     |-------------------------------------------------------------------------
     */

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param array $lastResponse
     */
    public function setLastResponse($lastResponse)
    {
        $this->lastResponse = $lastResponse;
    }

    /**
     * @return array
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param array $lastRequest
     */
    public function setLastRequest($lastRequest)
    {
        $this->lastRequest = $lastRequest;
    }

    /**
     * @return array()
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @param GetTravelsRequest $travel
     * @return array<Travel>
     * @throws InvalidArgumentException
     */
    public function getTravels(GetTravelsRequest $travelsRequest)
    {
       // ValidatorHelper::validate($travelsRequest, 'arrival');
        $response = $this->request(
            self::ENDPOINT_SCHEDULE,
            [
                'U_NAME'  => $this->config->getUserName(),
                'U_PASSWORD'  => $this->config->getPassword(),
                'CID' => $travelsRequest->getCid(),
                'ID_DEPARTURE'   => $travelsRequest->getIdDeparture(),
                'ID_ARRIVAL'=>$travelsRequest->getIdArrival(),
                'DATE_DEPARTURE'=>$travelsRequest->getDateDeparture()->format('Y-m-d') ,
                'TYPE_WAY'=>$travelsRequest->getTypeWay(),
                'DATE_RETURN'=>''
            ]
        );
        return $response;
    }

    public function getDepartures($cid)
    {
        // ValidatorHelper::validate($travelsRequest, 'arrival');
        $response = $this->request(
            self::ENDPOINT_ORIGIN_PLACES,
            [
                'U_NAME'  => $this->config->getUserName(),
                'U_PASSWORD'  => $this->config->getPassword(),
                'CID' => $cid
            ]
        );
        return $response;
    }

    public function getDestinations($cid, $departureId)
    {
        // ValidatorHelper::validate($travelsRequest, 'arrival');
        $response = $this->request(
            self::ENDPOINT_DESTINATION_PLACES,
            [
                'U_NAME'  => $this->config->getUserName(),
                'U_PASSWORD'  => $this->config->getPassword(),
                'CID' => $cid,
                'ID_DEPARTURE' => $departureId
            ]
        );
        return $response;
    }
}
