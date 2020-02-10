<?php

namespace App\Repositories\Frontend\Comments;

use App\Events\Frontend\Comments\CommentCreated;
use App\Events\Frontend\Comments\CommentDeleted;
use App\Events\Frontend\Comments\CommentUpdated;
use App\Exceptions\GeneralException;
use App\Models\Comments\Comment;
use App\Repositories\BaseRepository;
use DB;

/**
 * Class CommentsRepository.
 */
class CommentsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Comment::class;

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $data = [];
        $query = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.comments.table') . '.created_by')
            ->select([
                config('module.comments.table') . '.id',
                config('module.comments.table') . '.comment',
                config('module.comments.table') . '.type',
                config('module.comments.table') . '.status',
                config('module.comments.table') . '.created_at',
                config('module.comments.table') . '.created_by',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
            ])->get();
        $map = $query->map(function ($items) {
            $data['me'] = $items->created_by === access()->user()->id;
            $data['comment'] = $items->comment;
            $data['first_name'] = $items->first_name;
            $data['last_name'] = $items->last_name;
            $data['created_at'] = $items->created_at->format('d M Y H:i:s');
            $data['id'] = $items->id;

            return $data;
        });

        return $map;
    }

    /**
     * @throws \App\Exceptions\GeneralException
     *
     * @return mixed
     */
    public function create(array $input)
    {
        return DB::transaction(function () use ($input) {
            $input['created_by'] = access()->user()->id;
            if ($comment = Comment::create($input)) {
                event(new CommentCreated($comment));

                return $comment;
            }

            throw new GeneralException(trans('exceptions.backend.comments.create_error'));
        });
    }

    /**
     * Update Comment.
     */
    public function update(Comment $comment, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        DB::transaction(function () use ($comment, $input) {
            if ($comment->update($input)) {
                event(new CommentUpdated($comment));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.comments.update_error'));
        });
    }

    /**
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Comment $comment)
    {
        DB::transaction(function () use ($comment) {
            if ($comment->delete()) {
                event(new CommentDeleted($comment));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.comments.delete_error'));
        });
    }
}
