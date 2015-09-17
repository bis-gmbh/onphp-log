<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log;

use \Psr\Log\AbstractLogger;
use \Onphp\Log\Target\TargetInterface;
use \Onphp\Log\Target\DummyTarget;
use \Onphp\Log\Informer\InformerInterface;

/**
 * Class LoggerInstance
 * @package Onphp\Log
 */
class LoggerInstance extends AbstractLogger implements LoggerInstanceInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var TargetInterface[]
     */
    protected $targets;

    /**
     * @var InformerInterface[]
     */
    protected $informers;

    /**
     * @param string $name
     * @param TargetInterface[] $targets
     * @param InformerInterface[] $informers
     */
    public function __construct($name, $targets = [], $informers = [])
    {
        $this->name = $name;
        $this->targets = $targets;
        $this->informers = $informers;
    }

    /**
     * @param \Psr\Log\LogLevel $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        if (empty($this->targets)) {
            $this->addTarget(new DummyTarget());
        }

        $context['meta']['loggerName'] = $this->name;

        $record = [
            'level'    => strtoupper($level),
            'message'  => $message,
            'context'  => $context,
        ];

        if ( ! empty($this->informers)) {
            foreach ($this->informers as $informer) {
                $informerData = $informer->process($record['context']);
                if ($informerData) {
                    $record['informer'][$informer->getName()] = $informerData;
                }
            }
        }

        foreach ($this->targets as $target) {
            $target->process($record);
        }
    }

    /**
     * @param TargetInterface $target
     * @return LoggerInstance
     */
    public function addTarget(TargetInterface $target)
    {
        array_push($this->targets, $target);
        return $this;
    }

    /**
     * @return LoggerInstance
     */
    public function flushTargets()
    {
        $this->targets = [];
        return $this;
    }

    /**
     * @param InformerInterface $informer
     * @return LoggerInstance
     */
    public function addInformer(InformerInterface $informer)
    {
        array_push($this->informers, $informer);
        return $this;
    }

    /**
     * @return LoggerInstance
     */
    public function flushInformers()
    {
        $this->informers = [];
        return $this;
    }
}
