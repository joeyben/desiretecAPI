<?php

namespace Modules\Attachments\Repositories\Contracts;

use Modules\Attachments\Entities\Attachment;
use Modules\Attachments\Http\Requests\StoreAttachmentRequest;

interface AttachmentsRepository
{
    public function store(StoreAttachmentRequest $request): Attachment;
}
