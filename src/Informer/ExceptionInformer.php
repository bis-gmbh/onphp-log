<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

/**
 * Class ExceptionInformer
 * @package Onphp\Log\Informer
 */
class ExceptionInformer extends AbstractInformer
{
    protected $name = 'exception';

    /**
     * @param array $context
     * @return string|null
     */
    public function getData(array $context)
    {
        $data = null;

        if (
            isset($context[$this->name])
            && ($context[$this->name] instanceof \Exception)
        ) {
            /** @var \Exception $e */
            $e = $context[$this->name];
            $data = "\n\n"
                . "Exception:\n"
                . 'Class: ' . get_class($e) . "\n"
                . 'Code: ' . $e->getCode() . "\n"
                . 'Message: ' . $e->getMessage() . "\n\n"
                . $e->getTraceAsString() . "\n";
        }

        return $data;
    }
}
