<?php

namespace Modules\Backups\Http\Controllers;

use App\Services\Flag\Src\Flag;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Collection;
use Modules\Backups\Repositories\BackupsRepository;

class BackupsController extends Controller
{
    /**
     * @var \Modules\Backups\Repositories\BackupsRepository
     */
    private $backupsRepository;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;
    /**
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    private $storage;

    /**
     * BackupsController constructor.
     *
     * @param \Modules\Backups\Repositories\BackupsRepository $backupsRepository
     * @param \Illuminate\Routing\ResponseFactory             $response
     * @param \Illuminate\Filesystem\FilesystemManager        $storage
     */
    public function __construct(BackupsRepository $backupsRepository, ResponseFactory $response, FilesystemManager $storage)
    {
        $this->backupsRepository = $backupsRepository;
        $this->response = $response;
        $this->storage = $storage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('backups::index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        try {
            $data = $this->backupsRepository->getBackup();
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $per_page = $request->get('per_page');
            $currentPageResults = $collection->slice(($currentPage - 1) * $per_page, $per_page)->all();
            $result['data'] = new LengthAwarePaginator($currentPageResults, \count($collection), $per_page);
            $result['data']->setPath($request->url());

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_FORBIDDEN;
        }

        return $this->response->json($result['data'], $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     *
     * @param string $fileName
     *
     * @return $this|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(string $fileName)
    {
        try {
            $file = config('backup.backup.name') . '/' . $fileName;
            $disk = $this->storage->disk(config('backup.backup.destination.disks')[0]);
            if ($disk->exists($file)) {
                $fs = $this->storage->disk(config('backup.backup.destination.disks')[0])->getDriver();
                $stream = $fs->readStream($file);

                $result['success'] = true;
                $result['status'] = Flag::STATUS_CODE_SUCCESS;

                return $this->response->stream(function () use ($stream) {
                    fpassthru($stream);
                }, 200, [
                    'Content-Type'        => $fs->getMimetype($file),
                    'Content-Length'      => $fs->getSize($file),
                    'Content-disposition' => 'attachment; filename="' . basename($file) . '"',
                ]);
            } else {
                return redirect()->back()->withErrors('The backup file doesn\'t exist.');
            }
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_FORBIDDEN;

            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $result['message'] = $this->backupsRepository->create();

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_FORBIDDEN;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
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
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('backups::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('backups::edit');
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
     * @param string $file
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $file)
    {
        try {
            $result = $this->backupsRepository->delete($file);
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_FORBIDDEN;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}
