<?php

namespace RocketBus\Tornado\Factories;

use GuzzleHttp\Event\CompleteEvent;
use Psr\Log\LoggerInterface;
use RocketBus\Tornado\Type\Config;
use GuzzleHttp\Client as HttpClient;
use RocketBus\Tornado\Client;
use GuzzleHttp\Event\BeforeEvent;

/**
 * Class ClientFactory
 * @package RocketBus\Tornado\Factories
 */
class ClientFactory
{
    /**
     * @param Config $config
     * @param LoggerInterface $logger
     * @return Client
     */
    public static function create(Config $config, LoggerInterface $logger)
    {
        $httpClient = new HttpClient([
            'base_url' => $config->getBaseUrl(),
            'defaults' => [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'timeout' => $config->getTimeout(),
                'exceptions' => false
            ]
        ]);

        if ($config->isLogEvent()) {
            self::addListeners($httpClient, $logger);
        }
        return new Client($config, $httpClient);
    }

    /**
     * @param HttpClient $client
     * @param LoggerInterface $logger
     */
    protected static function addListeners(HttpClient $client, LoggerInterface $logger)
    {
        $emitter = $client->getEmitter();
        $emitter->on('before', function (BeforeEvent $event) use ($logger) {
            $data = [];
            parse_str($event->getRequest()->getBody()->getContents(), $data);
            $resourcePath = $event->getRequest()->getResource();
            $logger->info(
                '[REQUEST] ',
                [
                    'Path: ' => $resourcePath,
                    'Data: ' => $data
                ]
            );
        });
        $emitter->on('complete', function (CompleteEvent $event) use ($logger) {
            $data           = $event->getResponse()->json();
            $resourcePath   = $event->getRequest()->getResource();
            $logger->info(
                '[RESPONSE] ',
                [
                    'Path: ' => $resourcePath,
                    'Data: ' => $data,
                    'Status code' => $event->getResponse()->getStatusCode()
                ]
            );
        });
    }
}
