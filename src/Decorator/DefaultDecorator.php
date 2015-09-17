<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Decorator;

/**
 * Class DefaultDecorator
 * @package Onphp\Log\Decorator
 */
class DefaultDecorator implements DecoratorInterface
{
    /**
     * @param array $record
     * @return string
     */
    public function process(array $record)
    {
        return $record['message'] . "\n" . implode("\n", $record['informer']);
    }
}
