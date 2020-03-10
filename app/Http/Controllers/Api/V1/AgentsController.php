<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\AgentsControllerInterface;
use App\Http\Requests\Frontend\Agents\CreateAgentsRequest;
use App\Http\Requests\Frontend\Agents\DeleteAgentsRequest;
use App\Http\Requests\Frontend\Agents\ManageAgentsRequest;
use App\Http\Requests\Frontend\Agents\UpdateAgentsRequest;
use App\Repositories\Frontend\Agents\AgentsRepository;

class AgentsController extends APIController implements AgentsControllerInterface
{
    protected $repository;

    public function __construct(AgentsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listAgents(ManageAgentsRequest $request)
    {
        try {
            $agents['data'] = $this->repository->getAllWithAccess();

            return $this->responseJson($agents);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function getAgent(int $id, ManageAgentsRequest $request)
    {
        try {
            $agent['data'] = $this->repository->getById($id);

            return $this->responseJson($agent);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function create(CreateAgentsRequest $request)
    {
        try {
            $this->repository->createByApi($request->except('_token'));

            return $this->respondCreated('agent created successfully');
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function update(int $id, UpdateAgentsRequest $request)
    {
        try {
            $this->repository->updateByApi($id, $request);

            return $this->respondUpdated('agent updated successfully');
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function delete(int $id, DeleteAgentsRequest $request)
    {
        try {
            $this->repository->deleteAgentFromApi($id, $request);

            return $this->respondUpdated('agent deleted successfully');
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
