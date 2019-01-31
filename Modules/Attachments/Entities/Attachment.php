<?php

namespace Modules\Attachments\Entities;

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    public $guarded = [];

    protected $casts = [
        'online' => 'boolean',
    ];

    public $appends = ['url'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::deleted(function ($attachment) {
            $attachment->deleteFile();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable()
    {
        return $this->morphTo();
    }

    public function loadParameters(UploadedFile $file, $folder)
    {
        $this->name = mb_substr($file->getClientOriginalName(), 0, (mb_strrpos($file->getClientOriginalName(), '.')));
        $this->type = $folder;
        $this->extension = $file->getClientOriginalExtension();
        $this->mime_type = $file->getClientMimeType();
        $this->size = $file->getSize();
        $this->author = Auth::user()->full_name;

        return $this;
    }

    public function getUrlAttribute()
    {
        return Storage::disk('s3')->url(Flag::UPLOADS . DS . $this->type . DS . $this->basename);
    }

    public function deleteFile()
    {
        Storage::disk('s3')->delete(Flag::UPLOADS . DS . $this->type . DS . $this->basename);
    }
}