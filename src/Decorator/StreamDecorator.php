<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Decorator;

use \Onphp\Log\Informer\DatetimeInformer;

/**
 * Class StreamDecorator
 * @package Onphp\Log\Decorator
 */
class StreamDecorator implements DecoratorInterface
{
    /**
     * @param array $record
     * @return string
     */
    public function process(array $record)
    {
        if (isset($record['informer']['datetime'])) {
            $datetime = $record['informer']['datetime'];
            unset($record['informer']['datetime']);
        } else {
            $datetimeInformer = new DatetimeInformer();
            $datetime = $datetimeInformer->getData($record['context']);
        }
        $output = $datetime . "\t" . strtoupper($record['level']) . "\t" . $record['message'] . "\n";
        if ( ! empty($record['informer'])) {
            foreach ($record['informer'] as $name => $value) {
                $output .= ucfirst($name) . ":\n" . $value . "\n";
            }
        }
        return $output;
    }
}
