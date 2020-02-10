<?php

namespace Modules\Attachments\Http\Controllers;

use App\Exceptions\AttachmentException;
use App\Http\Controllers\Controller;
use App\Services\Flag\Src\Flag;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Attachments\Http\Requests\StoreAttachmentRequest;
use Modules\Attachments\Repositories\Contracts\AttachmentsRepository;

class AttachmentsController extends Controller
{
    /**
     * @var \Modules\Attachments\Repositories\Contracts\AttachmentsRepository
     */
    private $attachments;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;

    /**
     * AttachmentsController constructor.
     */
    public function __construct(AttachmentsRepository $attachments, ResponseFactory $response, AuthManager $auth, Translator $lang)
    {
        $this->attachments = $attachments;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
    }

    public function store(StoreAttachmentRequest $request)
    {
        try {
            if (class_exists($request->get('attachable_type'))
                && method_exists($request->get('attachable_type'), 'attachments')) {
                $subject = \call_user_func(
                    $request->get('attachable_type') . '::find',
                    (int) ($request->get('attachable_id'))
                );

                if ($subject || (0 === (int) $request->get('attachable_id'))) {
                    $attachment = $this->attachments->store($request);

                    $result['attachment'] = $attachment;
                    $result['message'] = $this->lang->get('messages.created', ['attribute' => 'File']);

                    return $this->responseJson($result);
                }
                throw AttachmentException::notFileReceiveException();
            }
            throw AttachmentException::undefinedMethodException($request->get('attachable_type'));
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function destroy(int $id)
    {
        try {
            $result['attachment'] = $this->attachments->delete($id);
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
            $result['success'] = true;
            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'File']);

            return $this->response->json($result, 200, [], JSON_NUMERIC_CHECK);
        } catch (Exception $e) {
            $result['success'] = false;
            $result['status'] = Flag::STATUS_CODE_ERROR;
            $result['message'] = $e->getMessage();

            return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
        }
    }
}
