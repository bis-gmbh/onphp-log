<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

/**
 * Class EchoTarget
 * @package Onphp\Log\Target
 */
class EchoTarget extends AbstractTarget
{
    /**
     * @param array $record
     * @return null
     */
    public function write(array $record)
    {
        echo $record['decorated'] . PHP_EOL;
    }
}
