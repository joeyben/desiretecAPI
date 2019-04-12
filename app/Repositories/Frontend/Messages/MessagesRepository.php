<?php

namespace App\Repositories\Frontend\Messages;

use App\Repositories\BaseRepository;
use App\Models\Messages\Message;
use DB;

/**
 * Class MessagesRepository.
 */
class MessagesRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Message::class;

    public function createInbound(array $data)
    {
        DB::transaction(function () use ($data) {
           
            if (Message::create($data)) {
                return true;
            }

            throw new GeneralException(trans('exceptions.frontend.messages.create_error'));
        });
    }
    
}
