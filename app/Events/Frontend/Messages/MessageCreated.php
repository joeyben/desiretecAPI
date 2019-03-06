<?php

namespace App\Events\Frontend\Messages;

use Illuminate\Queue\SerializesModels;

/**
 * Class MessageCreated.
 */
class MessageCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $message;

    /**
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
