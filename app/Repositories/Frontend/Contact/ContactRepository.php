<?php

namespace App\Repositories\Frontend\Contact;

use App\Events\Frontend\Contact\ContactCreated;
use App\Events\Frontend\Contact\ContactDeleted;
use App\Events\Frontend\Contact\ContactUpdated;
use App\Exceptions\GeneralException;
use App\Models\Access\User\User;
use App\Models\Contact\Contact;
use App\Models\Wishes\Wish;
use App\Repositories\BaseRepository;
use DB;

/**
 * Class ContactRepository.
 */
class ContactRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Contact::class;

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $data = [];
        $query = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.contact.table') . '.created_by')
            ->select([
                config('module.contact.table') . '.id',
                config('module.contact.table') . '.contact',
                config('module.contact.table') . '.type',
                config('module.contact.table') . '.status',
                config('module.contact.table') . '.created_at',
                config('module.contact.table') . '.created_by',
                config('access.users_table') . '.first_name as first_name',
                config('access.users_table') . '.last_name as last_name',
            ])->get();
        $map = $query->map(function ($items) {
            $data['me'] = $items->created_by === access()->user()->id;
            $data['contact'] = $items->contact;
            $data['first_name'] = $items->first_name;
            $data['last_name'] = $items->last_name;
            $data['created_at'] = $items->created_at->format('d M Y H:i:s');
            $data['id'] = $items->id;

            return $data;
        });

        return $map;
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return mixed
     */
    public function create(array $input)
    {
        return DB::transaction(function () use ($input) {
            $input['created_by'] = access()->user()->id;
            $input['wish_id'] = (int) ($input['wish_id']);
            $input['group_id'] = $this->getGroupId($input['wish_id']);

            if ($contact = Contact::create($input)) {
                if ($input['first_name']) {
                    $this->updateUserInfo($input);
                }
                event(new ContactCreated($contact));

                return $contact;
            }

            throw new GeneralException(trans('exceptions.backend.contact.create_error'));
        });
    }

    /**
     * Update Contact.
     *
     * @param \App\Models\Contact\Contact $contact
     * @param array                       $input
     */
    public function update(Contact $contact, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        DB::transaction(function () use ($contact, $input) {
            if ($contact->update($input)) {
                event(new ContactUpdated($contact));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.contact.update_error')
            );
        });
    }

    /**
     * @param \App\Models\Contact\Contact $contact
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Contact $contact)
    {
        DB::transaction(function () use ($contact) {
            if ($contact->delete()) {
                event(new ContactDeleted($contact));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.contact.delete_error'));
        });
    }

    /**
     * @param string $id
     *
     * @return int
     */
    public function getGroupId($id)
    {
        $wish = Wish::find($id);

        return $wish->group->id;
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function updateUserInfo($input)
    {
        $user = User::find(access()->user()->id);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];

        return $user->save();
    }
}
