<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type,$payload)
    {
        $this->type = $type;
        $this->payload = $payload;
    }
}