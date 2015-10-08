<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log;

use \Onphp\Log\Exception\InvalidArgumentException;

/**
 * Class LoggerRepository
 * @package Onphp\Log
 */
class LoggerRepository
{
    /**
     * @var LoggerInstanceInterface[]
     */
    protected static $repository;

    /**
     * @param LoggerInstanceInterface[] $loggers
     * @throws InvalidArgumentException
     */
    public static function add($loggers)
    {
        if (is_array($loggers) && count($loggers) > 0) {
            /** @var LoggerInstanceInterface $logger */
            foreach ($loggers as $logger) {
                self::push($logger);
            }
        } else {
            throw new InvalidArgumentException('Argument type must be not empty array of \Onphp\Log\LoggerInstance objects');
        }
    }

    /**
     * @param LoggerInstanceInterface $logger
     */
    public static function push(LoggerInstanceInterface $logger)
    {
        self::$repository[$logger->getName()] = $logger;
    }

    /**
     * @param string $name
     * @return LoggerInstanceInterface|null
     */
    public static function get($name)
    {
        return array_key_exists($name, self::$repository) ? self::$repository[$name] : null;
    }
}
