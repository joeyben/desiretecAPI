<?php

namespace App\Http\Controllers\Api\V1\Contracts;

use Illuminate\Http\Request;

interface MessagesControllerInterface
{
    public function list(int $wishId, int $groupId);

    public function create(Request $request);

    public function delete(int $id);

    public function update(int $id, Request $request);
}
