<?php

namespace Modules\Attachments\Http\Controllers;

use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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
     *
     * @param \Modules\Attachments\Repositories\Contracts\AttachmentsRepository $attachments
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     */
    public function __construct(AttachmentsRepository $attachments, ResponseFactory $response, AuthManager $auth, Translator $lang)
    {
        $this->attachments = $attachments;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('attachments::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('attachments::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Modules\Attachments\Http\Requests\StoreAttachmentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttachmentRequest $request)
    {
        if (class_exists($request->get('attachable_type'))
            && method_exists($request->get('attachable_type'), 'attachments')) {
            $subject = \call_user_func(
                $request->get('attachable_type') . '::find',
                (int) ($request->get('attachable_id'))
            );

            if ($subject || (0 === (int) $request->get('attachable_id'))) {
                try {
                    $attachment = $this->attachments->store($request);

                    $result['attachment'] = $attachment;
                    $result['status'] = Flag::STATUS_CODE_SUCCESS;
                    $result['success'] = true;
                    $result['message'] = $this->lang->get('messages.created', ['attribute' => 'File']);
                } catch (Exception $e) {
                    $result['status'] = Flag::STATUS_CODE_ERROR;
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
            } else {
                return $this->response->json(
                    ['attachable_id' => 'This content can not receive a file'],
                    Flag::STATUS_CODE_ERROR,
                    [],
                    JSON_NUMERIC_CHECK
                );
            }
        } else {
            return $this->response->json(
                ['error' => 'method attachments undefined'],
                Flag::STATUS_CODE_ERROR,
                [],
                JSON_NUMERIC_CHECK
            );
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('attachments::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('attachments::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
