<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log;

use \Onphp\Log\Target\TargetInterface;
use \Onphp\Log\Informer\InformerInterface;

/**
 * Interface LoggerInstanceInterface
 * @package Onphp\Log
 */
interface LoggerInstanceInterface
{
    /**
     * @param TargetInterface $target
     * @return mixed
     */
    public function addTarget(TargetInterface $target);

    /**
     * @param InformerInterface $informer
     * @return mixed
     */
    public function addInformer(InformerInterface $informer);
}
