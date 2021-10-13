<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $usertype;
    public $client_id;
    public $user_id;
    public $is_teacher;
    public $username;

    public function __construct($message, $usertype, $client_id, $user_id, $is_teacher, $username){
        $this->message = $message;
        $this->usertype = $usertype;
        $this->client_id = $client_id;
        $this->user_id = $user_id;
        $this->is_teacher = $is_teacher;
        $this->username = $username;
    }

    public function broadcastOn(){
        // return ['chat'];
        if ($this->usertype == 'students') {
            return ['chat_' . $this->client_id . '_' . $this->user_id];
        } else {
            return ['chat_' . $this->user_id . '_' . $this->client_id];
        }
    }

    public function broadcastAs(){
        return 'message';
    }
}
