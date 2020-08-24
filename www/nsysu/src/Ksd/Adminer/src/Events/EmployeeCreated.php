<?php

namespace Ksd\Adminer\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Ksd\Adminer\Models\Employee;

class EmployeeCreated
{
    use InteractsWithSockets, SerializesModels;

    public $employee;
    public $defaultPassword;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Employee $employee, $defaultPassword)
    {
        $this->employee = $employee;
        $this->defaultPassword = $defaultPassword;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
