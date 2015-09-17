<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Decorator;

/**
 * Interface InformerInterface
 * @package Onphp\Log\Decorator
 */
interface DecoratorInterface
{
    /**
     * @param array $record
     * @return string
     */
    public function process(array $record);
}
