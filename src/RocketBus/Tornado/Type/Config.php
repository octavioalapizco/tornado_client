<?php

namespace RocketBus\Tornado\Type;

use InvalidArgumentException;

/**
 * Class Config
 * @package RocketBus\Tornado\Type
 */
class Config
{
    const SALE_BY_INTERNET  = 12;
    const TICKET_TYPE       = '00';
    const PAYMENT_METHOD    = 2;
    const PAYMENT_AUTHORIZATION_NUMBER = '555555';
    const PAYMENT_SECURITY_NUMBER = '999';
    const PAYMENT_CARD_NUMBER = '9999';
    const PAYMENT_CARD_VALIDITY = '01/05/2019';
    const PAYMENT_CARD_TYPE = 'VISA';

    private static $busLinesIdsEnabled = ['01', '05' ,'38', '03' ,'04'];

    /**
     * @var array
     */
    protected $requiredField = [
        'userName',
        'password',
        'timeout',
        'baseUrl'
    ];

    /**
     * @return array
     */
    public function getRequiredField()
    {
        return $this->requiredField;
    }

    /**
     * @param array $requiredField
     */
    public function setRequiredField($requiredField)
    {
        $this->requiredField = $requiredField;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return boolean
     */
    public function isLogEvent()
    {
        return $this->logEvent;
    }

    /**
     * @param boolean $logEvent
     */
    public function setLogEvent($logEvent)
    {
        $this->logEvent = $logEvent;
    }


    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var bool
     */
    protected $logEvent;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->selfValidation($config);

        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->timeout = $config['timeout'];
        $this->baseUrl = $config['baseUrl'];
        $this->logEvent = isset($config['logEvent'])? $config['logEvent']: false;
    }

    /**
     * @param array $config
     * @throws InvalidArgumentException
     */
    public function selfValidation(array $config)
    {
        foreach ($this->requiredField as $fieldName) {
            if (!isset($config[$fieldName])) {
                $message = sprintf('The parameter "%s" is required.', $fieldName);
                throw new InvalidArgumentException($message);
            }
        }
    }

    /**
     * @return string
     */
    public function getBusLinesIdsEnabled()
    {
        return implode(',', self::$busLinesIdsEnabled);
    }
}
