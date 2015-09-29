<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Decorator;

use \Onphp\Log\Informer\DatetimeInformer;

/**
 * Class DummyDecorator
 * @package Onphp\Log\Decorator
 */
class DummyDecorator implements DecoratorInterface
{
    /**
     * @param array $record
     * @return string
     */
    public function process(array $record)
    {
        return $record['message'];
    }
}
