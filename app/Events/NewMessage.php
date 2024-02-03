<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private $id;
    private $body;
    private $user_id;
    private $chat_id;
    private $file;
    private $time;

    public function __construct( $dataEvent)
    {
        Log::info('id'.$dataEvent['id']);
        $this->id = $dataEvent['id']??"";
        $this->body = $dataEvent['body']??"";
        $this->user_id = $dataEvent['sender'];
        $this->chat_id = $dataEvent['chat_id'];
        $this->file = $dataEvent['file']??"";
        $this->time = now();
    }


    public function broadcastOn()
    {
      return new Channel('new-message');
    }

    public function broadcastWith()
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'body'=>$this->body,
            'chat_id'=>$this->chat_id??"",
            'file'=>$this->file??"",
            'time'=>$this->time,
        ];
    }


}
