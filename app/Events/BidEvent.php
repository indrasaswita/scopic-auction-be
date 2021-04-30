<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $itemuser;
	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($itemuser, $user)
	{
		$this->itemuser = $itemuser;
		$this->user = $user;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new Channel('bid.'.$this->itemuser['item_id']);
	}

	public function broadcastAs()
	{
		return 'scopic_auction';
	}

	public function broadcastWith() {
		return [
			'itemuser' => $this->itemuser,
			'user' => $this->user,
		];
	}
}
