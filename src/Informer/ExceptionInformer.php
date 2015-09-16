<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

/**
 * Class ExceptionInformer
 * @package Onphp\Log\Informer
 */
class ExceptionInformer implements InformerInterface
{
    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->setException($e);
    }

    /**
     * @param \Exception $e
     * @return ExceptionInformer
     */
    public function setException(\Exception $e)
    {
        $this->exception = $e;
        return $this;
    }

    /**
     * @param array $record
     * @return array
     */
    public function process(array $record)
    {
        $record['message'] .= "\n\n"
            . "Exception:\n"
            . 'Class: ' . get_class($this->exception) . "\n"
            . 'Code: ' . $this->exception->getCode() . "\n"
            . 'Message: ' . $this->exception->getMessage() . "\n\n"
            . $this->exception->getTraceAsString() . "\n";

        return $record;
    }
}
