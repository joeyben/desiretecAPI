<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Attachments\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use App\Services\Flag\Src\Flag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Attachments\Entities\Attachment;
use Modules\Attachments\Http\Requests\StoreAttachmentRequest;
use Modules\Attachments\Repositories\Contracts\AttachmentsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentAttachmentsRepository extends RepositoryAbstract implements AttachmentsRepository
{
    public function model()
    {
        return Attachment::class;
    }

    public function store(StoreAttachmentRequest $request): Attachment
    {
        $attachment = new Attachment(['attachable_type' => $request->get('attachable_type'), 'attachable_id' => $request->get('attachable_id')]);
        $attachment->basename = $this->makeImage($request->file('attachment'), $request->get('type') . DS . $request->get('folder'));

        $attachment->loadParameters($request->file('attachment'), $request->get('type') . DS . $request->get('folder'));

        $attachment->save();

        return $attachment;
    }

    private function makeImage(UploadedFile $file, string $folder)
    {
        $path = Flag::UPLOADS . \DIRECTORY_SEPARATOR . $folder . \DIRECTORY_SEPARATOR;
        $attachment = $file;
        $fileName = time() . $attachment->getClientOriginalName();

        Storage::disk('s3')->put($path . $fileName, file_get_contents($attachment->getRealPath()), 'public');

        return $fileName;
    }

    /**
     * @param string $id
     * @param string $type
     *
     * @return mixed
     */
    public function getAttachementsByType($id, $type)
    {
        $attachments = $this->model
            ->select([
                config('module.attachments.table') . '.basename',
                config('module.attachments.table') . '.type',
            ])
            ->where('attachable_id', (int) $id)
            ->where('type', 'whitelabels/' . $type)
            ->first();

        if (null !== $attachments) {
            return $attachments->toArray();
        }

        return null;
    }
}
