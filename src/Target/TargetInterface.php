<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

/**
 * Interface TargetInterface
 * @package Onphp\Log\Target
 */
interface TargetInterface
{
    /**
     * @param array $record
     * @return bool
     */
    public function process(array $record);

    /**
     * @param array $record
     * @return mixed
     */
    public function write(array $record);
}
