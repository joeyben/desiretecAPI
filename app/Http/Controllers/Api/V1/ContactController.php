<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\ManageContactRequest;
use App\Http\Requests\Frontend\Contact\StoreCallbackRequest;
use App\Http\Requests\Frontend\Contact\StoreContactRequest;
use App\Http\Requests\Frontend\Contact\UpdateContactRequest;
use App\Models\Contact\Contact;
use App\Repositories\Frontend\Contact\ContactRepository;

/**
 * Class ContactController.
 */
class ContactController extends APIController
{
    const BODY_CLASS = 'contact';

    /**
     * @var ContactRepository
     */
    protected $contact;

    public function __construct(ContactRepository $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function store(StoreContactRequest $request)
    {
        try{
            $contact = $this->contact->create($request->all());

            return $this->responseJson([
                'success' => true,
                'message' => trans('alerts.frontend.contact.success')
            ]);
        } catch (\Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    /**
     * @return mixed
     */
    public function storeCallback(StoreCallbackRequest $request)
    {
        try{
            $contact = $this->contact->create($request->all());

            return $this->responseJson([
                'success' => true,
                'message' => trans('alerts.frontend.contact.success')
            ]);
        } catch (\Exception $e) {
            return $this->responseJsonError($e);
        }
    }
}