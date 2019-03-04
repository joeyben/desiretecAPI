<?php

namespace App\Events\Frontend\Contact;

use Illuminate\Queue\SerializesModels;

/**
 * Class ContactCreated.
 */
class ContactCreated
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
