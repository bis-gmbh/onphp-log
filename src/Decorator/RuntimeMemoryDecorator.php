<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Decorator;

/**
 * Class RuntimeMemoryDecorator
 * @package Onphp\Log\Decorator
 */
class RuntimeMemoryDecorator implements DecoratorInterface
{
    /**
     * @param array $record
     * @return string
     */
    public function process(array $record)
    {
        $message = '';

        $backTrace = debug_backtrace();

        for ($i = count($backTrace) - 1; $i >= 0; $i--) {

            $oneCall = $backTrace[$i];

            if (
                isset($oneCall['class'])
                && (
                    ($oneCall['class'] == get_class($this))
                    || ($oneCall['class'] == '\Onphp\Log\LoggerInstance')
                )
            ) {
                $file = $oneCall['file'];
                $line = $oneCall['line'];

                $message = $file . "($line)";
                
                if (isset($record['informer']['datetime'])) {
                    $message .= "\n\nDate: " . $record['informer']['datetime'];
                    unset($record['informer']['datetime']);
                }
                $message .= "\n\nMessage: " . $record['message'] . "\n" . implode("\n", $record['informer']) . "\n\n";

                break;
            }
        }

        $output = "Log:\n-----------------------\n" . $message;

        return '<pre>' . $output . '</pre>';
    }
}
