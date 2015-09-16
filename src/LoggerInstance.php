<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log;

use \Psr\Log\AbstractLogger;
use \Onphp\Log\Target\TargetInterface;
use \Onphp\Log\Target\DummyTarget;
use \Onphp\Log\Informer\InformerInterface;
use \Onphp\Log\Informer\DummyInformer;

/**
 * Class LoggerInstance
 * @package Onphp\Log
 */
class LoggerInstance extends AbstractLogger implements LoggerInstanceInterface
{
    const INSERT_TO_BEGIN = 0x1;

    const INSERT_TO_END = 0x2;

    /**
     * @var \DateTimeZone
     */
    protected static $timezone;

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
        if (empty($this->informers)) {
            $this->addInformer(new DummyInformer());
        }

        if ( ! static::$timezone) {
            static::$timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }
        $datetime = \DateTime::createFromFormat(
            'U.u', sprintf('%.6F', microtime(true)), static::$timezone
        );
        $datetime->setTimezone(static::$timezone);

        $context['meta']['loggerName'] = $this->name;
        $context['meta']['datetimeObject'] = $datetime;

        $record = [
            'datetime' => $datetime->format('Y-m-d H:i:s'),
            'level'    => strtoupper($level),
            'message'  => $message,
            'context'  => $context,
        ];

        foreach ($this->informers as $informer) {
            $record = $informer->process($record);
        }

        foreach ($this->targets as $target) {
            $target->write($record);
        }
    }

    /**
     * @param TargetInterface $target
     * @param int $position
     * @return LoggerInstance
     */
    public function addTarget(TargetInterface $target, $position = self::INSERT_TO_END)
    {
        if ($position === self::INSERT_TO_BEGIN) {
            array_unshift($this->targets, $target);
        } else {
            array_push($this->targets, $target);
        }
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
     * @param int $position
     * @return LoggerInstance
     */
    public function addInformer(InformerInterface $informer, $position = self::INSERT_TO_END)
    {
        if ($position === self::INSERT_TO_BEGIN) {
            array_unshift($this->informers, $informer);
        } else {
            array_push($this->informers, $informer);
        }
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
