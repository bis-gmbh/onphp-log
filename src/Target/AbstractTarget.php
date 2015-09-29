<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

use \Psr\Log\LogLevel;
use \Onphp\Log\Decorator\DecoratorInterface;
use \Onphp\Log\Decorator\DummyDecorator;
use \Onphp\Log\InternalLevel;

/**
 * Class AbstractTarget
 * @package Onphp\Log\Target
 */
abstract class AbstractTarget implements TargetInterface
{
    /**
     * @var string target system name
     */
    protected $name;

    /**
     * @var DecoratorInterface
     */
    protected $decorator;

    /**
     * @var integer
     */
    protected $minProcessingLevel;

    /**
     * @param string $level
     */
    public function __construct($level = LogLevel::DEBUG)
    {
        $this->minProcessingLevel = InternalLevel::get($level);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param DecoratorInterface $decorator
     * @return TargetInterface
     */
    public function setDecorator(DecoratorInterface $decorator)
    {
        $this->decorator = $decorator;
        return $this;
    }

    /**
     * @param array $record
     * @return bool
     */
    public function process(array $record)
    {
        $recordLevel = InternalLevel::get($record['level']);
        if ($recordLevel < $this->minProcessingLevel) {
            return false;
        }

        if ( ! ($this->decorator instanceof DecoratorInterface)) {
            $this->setDefaultDecorator();
        }

        $record['decorated'] = $this->decorator->process($record);
        $this->write($record);

        return true;
    }

    /**
     * @param array $record
     * @return null
     */
    abstract public function write(array $record);

    /**
     * Give ability to set default decorator in child classes
     */
    protected function setDefaultDecorator()
    {
        $this->decorator = new DummyDecorator();
    }
}
