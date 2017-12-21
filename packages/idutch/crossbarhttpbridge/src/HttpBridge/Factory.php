<?php

namespace iDutch\CrossbarHttpBridge\HttpBridge;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Factory
 * @package iDutch\CrossbarHttpBridge\HttpBridge
 */
class Factory
{
    /**
     * @param string $protocol
     * @param string $host
     * @param int $port
     * @param string $path
     * @param string $key
     * @param string $secret
     * @param bool|string $hostname
     * @param bool $ignoreSsl
     * @return Publisher
     */
    public function createPublisher($protocol, $host, $port, $path, $key, $secret, $hostname, $ignoreSsl)
    {
        $config = [];
        $config['base_url'] = sprintf(
            '%s://%s:%s%s',
            $protocol,
            $host,
            $port,
            $path
        );
        $config['base_uri'] = $config['base_url']; // Guzzle 6 compat
        $config['headers']['Content-Type'] = 'application/json';
        if (null !== $hostname) {
            $config['headers']['Host'] = $hostname;
        }
        if ($ignoreSsl) {
            $config['verify'] = false;
        }
        $guzzleClient = new GuzzleClient($config);
        return new Publisher($guzzleClient, $key, $secret);
    }

    /**
     * @param string $protocol
     * @param string $host
     * @param int $port
     * @param string $path
     * @param string $key
     * @param string $secret
     * @param bool|string $hostname
     * @param bool $ignoreSsl
     * @return Publisher
     */
    public function createCaller($protocol, $host, $port, $path, $key, $secret, $hostname, $ignoreSsl)
    {
        $config = [];
        $config['base_url'] = sprintf(
            '%s://%s:%s%s',
            $protocol,
            $host,
            $port,
            $path
        );
        $config['base_uri'] = $config['base_url']; // Guzzle 6 compat
        $config['headers']['Content-Type'] = 'application/json';
        if (null !== $hostname) {
            $config['headers']['Host'] = $hostname;
        }
        if ($ignoreSsl) {
            $config['verify'] = false;
        }
        $guzzleClient = new GuzzleClient($config);
        return new Caller($guzzleClient, $key, $secret);
    }
}
