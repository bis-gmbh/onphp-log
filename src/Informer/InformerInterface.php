<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

/**
 * Interface InformerInterface
 * @package Onphp\Log\Informer
 */
interface InformerInterface
{
    /**
     * @param array $record
     * @return mixed
     */
    public function process(array $record);
}
