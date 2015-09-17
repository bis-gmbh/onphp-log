<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

/**
 * Class DummyTarget
 * @package Onphp\Log\Target
 */
class DummyTarget extends AbstractTarget
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
