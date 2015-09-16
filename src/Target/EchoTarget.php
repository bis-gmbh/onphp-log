<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

/**
 * Class EchoTarget
 * @package Onphp\Log\Target
 */
class EchoTarget implements TargetInterface
{
    /**
     * @param array $record
     * @return null
     */
    public function write(array $record)
    {
        unset($record['context']);
        echo '<pre>' . implode("\t", $record) . '</pre>';
    }
}
