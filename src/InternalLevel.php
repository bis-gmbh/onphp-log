<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log;

use \Psr\Log\LogLevel;
use \Onphp\Log\Exception\InvalidArgumentException;

/**
 * Class InternalLevel
 * @package Onphp\Log
 */
class InternalLevel extends LogLevel
{
    /**
     * @var array
     */
    protected static $level = [
        self::DEBUG     => 0x1,
        self::INFO      => 0x2,
        self::NOTICE    => 0x4,
        self::WARNING   => 0x8,
        self::ERROR     => 0x16,
        self::CRITICAL  => 0x32,
        self::ALERT     => 0x64,
        self::EMERGENCY => 0x128,
    ];

    /**
     * @param string $value
     * @return integer
     * @throws InvalidArgumentException
     */
    public static function get($value)
    {
        if (isset(self::$level[$value])) {
            return self::$level[$value];
        } else {
            throw new InvalidArgumentException('Level "' . (string)$value . '" not found');
        }
    }

    /**
     * @param integer $id
     * @return string
     * @throws InvalidArgumentException
     */
    public function name($id)
    {
        if (in_array(intval($id), self::$level)) {
            return array_search($id, self::$level);
        } else {
            throw new InvalidArgumentException('Name for level id = ' . (string)$id . ' not found');
        }
    }
}
