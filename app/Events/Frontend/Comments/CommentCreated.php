<?php

namespace App\Events\Frontend\Comments;

use Illuminate\Queue\SerializesModels;

/**
 * Class CommentCreated.
 */
class CommentCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $comments;

    /**
     * @param $comments
     */
    public function __construct($comments)
    {
        $this->comments = $comments;
    }
}
