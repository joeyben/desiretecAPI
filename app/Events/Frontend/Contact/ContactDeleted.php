<?php

namespace App\Events\Frontend\Contact;

use Illuminate\Queue\SerializesModels;

/**
 * Class ContactDeleted.
 */
class ContactDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $contact;

    /**
     * @param $contact
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }
}
