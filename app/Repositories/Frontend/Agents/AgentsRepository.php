<?php

namespace App\Repositories\Frontend\Agents;

use App\Events\Frontend\Agents\AgentCreated;
use App\Events\Frontend\Agents\AgentDeleted;
use App\Events\Frontend\Agents\AgentUpdated;
use App\Exceptions\GeneralException;
use App\Models\Agents\Agent;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class AgentsRepository.
 */
class AgentsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Agent::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'agent'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.agents.table').'.user_id')
            ->select([
                config('module.agents.table').'.id',
                config('module.agents.table').'.name',
                config('module.agents.table').'.avatar',
                config('module.agents.table').'.display_name',
                config('module.agents.table').'.user_id',
                config('module.agents.table').'.created_at',
            ])->where(config('module.agents.table').'.user_id', access()->user()->id);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {

        DB::transaction(function () use ($input) {
            $input = $this->uploadImage($input);
            $input['user_id'] = access()->user()->id;

            if ($agent = Agent::create($input)) {

                event(new AgentCreated($agent));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.agents.create_error'));
        });
    }

    /**
     * Update Agent.
     *
     * @param \App\Models\Agents\Agent $agent
     * @param array                  $input
     */
    public function update(Agent $agent, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (array_key_exists('avatar', $input)) {
            $this->deleteOldFile($agent);
            $input = $this->uploadImage($input);
        }

        DB::transaction(function () use ($agent, $input) {
            if ($agent->update($input)) {

                event(new AgentUpdated($agent));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.agents.update_error')
            );
        });
    }



    /**
     * @param \App\Models\Agents\Agent $agent
     *
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
        $avatar = $input['avatar'];

        if (isset($input['avatar']) && !empty($input['avatar'])) {
            $fileName = time().$avatar->getClientOriginalName();

            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));

            $input = array_merge($input, ['avatar' => $fileName]);

            return $input;
        }
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        $fileName = $model->file;

        return $this->storage->delete($this->upload_path.$fileName);
    }
}
