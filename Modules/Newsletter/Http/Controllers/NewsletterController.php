<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Modules\Newsletter\Repositories\Contracts\NewsletterRepository;

class NewsletterController extends Controller
{
    /**
     * @var \Modules\Newsletter\Repositories\Contracts\NewsletterRepository
     */
    private $newsletter;
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
     * NewsletterController constructor.
     *
     * @param \Modules\Newsletter\Repositories\Contracts\NewsletterRepository $newsletter
     * @param \Illuminate\Routing\ResponseFactory                             $response
     * @param \Illuminate\Auth\AuthManager                                    $auth
     * @param \Illuminate\Translation\Translator                              $lang
     */
    public function __construct(NewsletterRepository $newsletter, ResponseFactory $response, AuthManager $auth, Translator $lang)
    {
        $this->newsletter = $newsletter;
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
        return view('newsletter::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('newsletter::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $this->newsletter->subscribe($request->get('email'));

            return redirect()->back()->with('success', 'subscribed user successfully');
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();

            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('newsletter::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return view('newsletter::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
    }
}
