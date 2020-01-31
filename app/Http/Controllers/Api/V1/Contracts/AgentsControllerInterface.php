<?php

namespace App\Http\Controllers\Api\V1\Contracts;

use App\Http\Requests\Frontend\Agents\ManageAgentsRequest;
use App\Http\Requests\Frontend\Agents\CreateAgentsRequest;
use App\Http\Requests\Frontend\Agents\UpdateAgentsRequest;
use App\Http\Requests\Frontend\Agents\DeleteAgentsRequest;


Interface AgentsControllerInterface
{
    public function listAgents(ManageAgentsRequest $request);

    public function getAgent(int $id, ManageAgentsRequest $request);

    public function create(CreateAgentsRequest $request);

    public function update(int $id, UpdateAgentsRequest $request);

    public function delete(int $id, DeleteAgentsRequest $request);
}
