<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

/**
 * Class DummyInformer
 * @package Onphp\Log\Informer
 */
class DummyInformer implements InformerInterface
{
    /**
     * @param array $record
     * @return array
     */
    public function process(array $record)
    {
        return $record;
    }
}
