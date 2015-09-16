<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

/**
 * Class DummyTarget
 * @package Onphp\Log\Target
 */
class DummyTarget implements TargetInterface
{
    /**
     * @param array $record
     * @return null
     */
    public function write(array $record)
    {
        // do nothing...
    }
}
