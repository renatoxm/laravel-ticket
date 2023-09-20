<?php

namespace Renatoxm\LaravelTicket\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * @method handle(object $event)
 */
abstract class QueueableListener implements ShouldQueue
{
    public static $shouldQueue = false;

    public function shouldQueue($event)
    {
        if (static::$shouldQueue) {
            return true;
        } else {
            // The listener is not queued so we manually
            // pass the event to the handle() method.
            $this->handle($event);

            return false;
        }
    }
}
