<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

use \Onphp\Log\Decorator\DecoratorInterface;
use \Onphp\Log\Decorator\DefaultDecorator;

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
     * @param DecoratorInterface|null $decorator
     */
    public function __construct(DecoratorInterface $decorator = null)
    {
        if ($decorator instanceof DecoratorInterface) {
            $this->setDecorator($decorator);
        }
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
     */
    public function setDecorator(DecoratorInterface $decorator)
    {
        $this->decorator = $decorator;
    }

    /**
     * @param array $record
     */
    public function process(array $record)
    {
        if ( ! ($this->decorator instanceof DecoratorInterface)) {
            $this->decorator = new DefaultDecorator();
        }
        $record['message'] = $this->decorator->process($record);
        $this->write($record);
    }

    /**
     * @param array $record
     * @return null
     */
    abstract public function write(array $record);
}
