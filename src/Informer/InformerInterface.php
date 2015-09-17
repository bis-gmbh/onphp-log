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
     * @return string
     */
    public function getName();

    /**
     * @param array $context
     * @return string
     */
    public function process(array $context);

    /**
     * @param array $context
     * @return string|null
     */
    public function getData(array $context);
}
