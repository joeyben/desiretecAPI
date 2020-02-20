<?php

namespace App\Repositories\Frontend\Agents;

use App\Events\Frontend\Agents\AgentCreated;
use App\Events\Frontend\Agents\AgentDeleted;
use App\Events\Frontend\Agents\AgentUpdated;
use App\Exceptions\GeneralException;
use App\Models\Agents\Agent;
use App\Repositories\BaseRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// TODO: When switch to the whitelabel-module solution
    // To delete:
        // $upload_path
        // $storage
        // getForDataTable()
        // create()
        // update()
        // doUpdate()
        // deleteAgent()
        // updateStatus()
        // uploadImage()
        // deleteOldFile()
    // To rename:
        // createByApi() to create()
        // updateByApi() to update()
    // To create and implement:
        // AgentsRepositryInterface

/**
 * Class AgentsRepository.
 */
class AgentsRepository extends BaseRepository
{
    const MODEL = Agent::class;

    protected $upload_path;

    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'agent' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.agents.table') . '.user_id')
            ->select([
                config('module.agents.table') . '.id',
                config('module.agents.table') . '.name',
                config('module.agents.table') . '.avatar',
                config('module.agents.table') . '.display_name',
                config('module.agents.table') . '.status',
                config('module.agents.table') . '.user_id',
                config('module.agents.table') . '.created_at',
            ])->where(config('module.agents.table') . '.user_id', access()->user()->id);
    }

    /**
     * @return mixed
     */
    public function getAllWithAccess()
    {
        return DB::table('agents')
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.agents.table') . '.user_id')
            ->select([
                config('module.agents.table') . '.id',
                config('module.agents.table') . '.name',
                config('module.agents.table') . '.avatar',
                config('module.agents.table') . '.display_name',
                config('module.agents.table') . '.user_id',
                config('module.agents.table') . '.created_at',
            ])->where(config('module.agents.table') . '.user_id', Auth::user()->id)
            ->get()
            ->toArray();
    }

    /**
     * @return mixed
     */
    public function getById(int $id)
    {
        return Agent::findOrFail($id);
    }

    /**
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        DB::transaction(function () use ($input) {
            $input = $this->uploadImage($input);
            $input['user_id'] = access()->user()->id;
            $input['display_name'] = $input['name'];
            $input['status'] = 'Active';

            if ($agent = Agent::create($input)) {
                event(new AgentCreated($agent));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.agents.create_error'));
        });
    }

    /**
     * Update Agent.
     */
    public function update(Agent $agent, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (\array_key_exists('avatar', $input)) {
            $this->deleteOldFile($agent);
            $input = $this->uploadImage($input);
        }

        DB::transaction(function () use ($agent, $input) {
            if ($agent->update($input)) {
                event(new AgentUpdated($agent));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.agents.update_error'));
        });
    }

    /**
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Agent $agent)
    {
        DB::transaction(function () use ($agent) {
            if ($agent->delete()) {
                event(new AgentDeleted($agent));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.agents.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {
        if (!\is_array($input)) {
            $input = [];
        }

        if (isset($input['avatar']) && !empty($input['avatar'])) {
            $avatar = $input['avatar'];

            $fileName = time() . $avatar->getClientOriginalName();

            $this->storage->put($this->upload_path . $fileName, file_get_contents($avatar->getRealPath()), 'public');

            $input = array_merge($input, ['avatar' => $fileName]);

            return $input;
        }

        $fileName = 'avatar_default';

        $this->storage->put($this->upload_path . $fileName, file_get_contents('https://desiretec.s3.eu-central-1.amazonaws.com/img/agent/1570145950wAvatarCallCenter2.png'), 'public');

        $input = array_merge($input, ['avatar' => $fileName]);

        return $input;
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        $fileName = $model->file;

        return $this->storage->delete($this->upload_path . $fileName);
    }

    public function deleteAgent($id)
    {
        $whitelabel_group = DB::table('groups')->where('whitelabel_id', getCurrentWhiteLabelId())->first();
        $user_group = null;
        $first_agent = null;

        if ($whitelabel_group) {
            $user_group = DB::table('group_user')->where('group_id', $whitelabel_group->id)->first();
        }
        if ($user_group) {
            $first_agent = DB::table('agents')->where([['user_id', $user_group->user_id], ['status', 'Active'], ['id', '!=', $id]])->first();
        }
        if ($first_agent) {
            DB::table('offers')->where('agent_id', '=', $id)->update(['agent_id' => $first_agent->id]);
            DB::table('message')->where('agent_id', '=', $id)->update(['agent_id' => $first_agent->id]);
        } else {
            DB::table('offers')->where('agent_id', '=', $id)->delete();
            DB::table('message')->where('agent_id', '=', $id)->delete();
        }
        DB::table('agents')->where('id', '=', $id)->delete();
    }

    public function doUpdate($id, Request $request)
    {
        if (\array_key_exists('avatar', $request->all())) {
            $avatar = ['avatar' => $this->uploadImage(['avatar' => $request->avatar])]['avatar']['avatar'];

            DB::table('agents')
                ->where('id', $id)
                ->update(['name' => $request->name, 'email' => $request->email, 'telephone' => $request->telephone, 'avatar' => $avatar]);
        } else {
            DB::table('agents')
                ->where('id', $id)
                ->update(['name' => $request->name, 'email' => $request->email, 'telephone' => $request->telephone]);
        }
    }

    public function updateStatus($active_id)
    {
        $id = Auth::id();
        $active_agent = Agent::where('user_id', $id)->where('status', 'Active')->first();

        $active_agent->status = 'InActive';
        if ($active_agent->save()) {
            $agent = Agent::find($active_id);
            $agent->status = 'Active';

            if ($agent->save()) {
                return true;
            }
        }
    }

    public function updateByApi($id, Request $request)
    {
        DB::table('agents')
            ->where('id', $id)
            ->update(['name' => $request->name, 'email' => $request->email, 'telephone' => $request->telephone]);

        if (isset($request->avatar)) {
            DB::table('agents')
            ->where('id', $id)
            ->update(['avatar' => $request->avatar]);
        }
    }

    public function createByApi(array $input)
    {
        DB::transaction(function () use ($input) {
            $input['user_id'] = access()->user()->id;
            $input['display_name'] = $input['name'];
            $input['avatar'] = $input['avatar'];

            if ($agent = Agent::create($input)) {
                event(new AgentCreated($agent));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.agents.create_error'));
        });
    }
}
