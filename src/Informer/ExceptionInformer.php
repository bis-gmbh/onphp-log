<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

use \Onphp\Log\InvalidConfigurationException;

/**
 * Class ExceptionInformer
 * @package Onphp\Log\Informer
 */
class ExceptionInformer extends AbstractInformer
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
        $this->name = 'exception';
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
     * @return string
     * @throws InvalidConfigurationException
     */
    public function getData()
    {
        if ($this->exception === null) {
            throw new InvalidConfigurationException('Exception object not found');
        }

        $data = "\n\n"
            . "Exception:\n"
            . 'Class: ' . get_class($this->exception) . "\n"
            . 'Code: ' . $this->exception->getCode() . "\n"
            . 'Message: ' . $this->exception->getMessage() . "\n\n"
            . $this->exception->getTraceAsString() . "\n";

        return $data;
    }
}
