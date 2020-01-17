<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agents\Agent;
use App\Repositories\Frontend\Agents\AgentsRepository;
use Illuminate\Http\Request;
use App\Http\Resources\PagesResource;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class AgentsController extends APIController
{
    protected $repository;

    public function __construct(AgentsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAgents(Request $request)
    {
        // (Milena) TODO: Stop using datatables
        try {
            return Datatables::of($this->repository->getForDataTable())
                ->addColumn('avatar', function ($repository) {
                    $path = Storage::disk('s3')->url('img/agent/');
                    return '<img src="' . $path . $repository->avatar . '"/>';
                })
                ->addColumn('name', function ($repository) {
                    return $repository->name;
                })
                ->addColumn('display_name', function ($repository) {
                    return $repository->display_name;
                })
                ->addColumn('actions', function ($repository) {
                    return '<a href="' . 'localhost:8001/agents/update/' . $repository->id . '">' . trans('labels.agents.edit') . '</a> / ' . '<a href="' . 'localhost:8001/agents/delete/' . $repository->id . '">' . trans('labels.agents.delete') . '</a>';
                })
                ->addColumn('created_at', function ($repository) {
                    return $repository->created_at->toFormattedDateString() . ' ' . $repository->created_at->toTimeString();
                })
                ->rawColumns(['avatar', 'actions', 'status'])->make(true);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function create(Request $request)
    {
        try {
           $validator = $this->validateRequest($request);

            if ($validator->fails()) {
                return $this->throwValidation('validation failed');
            }

            $this->repository->create($request->except('_token'));

            return $this->respondCreated('agent created successfully');

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $validator = $this->validateRequest($request);

            if ($validator->fails()) {
                return $this->throwValidation('validation failed');
            }

            $this->repository->doUpdate($id, $request);

            return $this->respondUpdated('agent updated successfully');

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function delete($id)
    {
        try {
            $this->repository->deleteAgent($id);

            return $this->respondUpdated('agent deleted successfully');

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    protected function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:55',
            'email' => 'required|email|max:255|unique:agents,email',
            'telephone' => 'required|integer'
        ]);

        return $validator;
    }
}
