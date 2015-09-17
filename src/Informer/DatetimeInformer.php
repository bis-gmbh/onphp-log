<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

/**
 * Class DatetimeInformer
 * @package Onphp\Log\Informer
 */
class DatetimeInformer extends AbstractInformer
{
    /**
     * @var \DateTimeZone
     */
    protected $timezone;

    /**
     * @var string
     */
    protected $format;

    public function __construct()
    {
        $this->name = 'datetime';
        $this->setFormat('Y-m-d H:i:s');
    }

    /**
     * @param $timezone \DateTimeZone
     * @return DatetimeInformer
     */
    public function setTimezone(\DateTimeZone $timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * @param string $format
     * @return DatetimeInformer
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @param array $context
     * @return string
     */
    public function getData(array $context)
    {
        if ( ! $this->timezone instanceof \DateTimeZone) {
            $this->timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }
        $datetime = \DateTime::createFromFormat(
            'U.u', sprintf('%.6F', microtime(true)), $this->timezone
        );
        $datetime->setTimezone($this->timezone);

        $data = $datetime->format($this->format);

        return $data;
    }
}
