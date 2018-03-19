<?php
/**
 * Created by PhpStorm.
 * User: Richard Hoogstraaten
 * Date: 19/03/2018
 * Time: 12:24
 */

namespace iDutch\CrossbarHttpBridge\HttpBridge;

interface CrossbarHttpBridgeInterface
{

    /**
     * @param string $topic
     * @param null $args
     * @param null $kwargs
     * @return array
     */
    public function publish(string $topic, $args = null, $kwargs = null): array;

    /**
     * @param string $procedure
     * @param null $args
     * @param null $kwargs
     * @return array
     */
    public function call(string $procedure, $args = null, $kwargs = null): array;

}