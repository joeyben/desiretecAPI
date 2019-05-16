<?php

namespace App\Repositories\Frontend\Access\User;

use App\Events\Frontend\Auth\UserConfirmed;
use App\Exceptions\GeneralException;
use App\Models\Access\User\SocialLogin;
use App\Models\Access\User\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->query()->where('email', $email)->first();
    }

    /**
     * @param $token
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function findByToken($token)
    {
        return $this->query()->where('confirmation_code', $token)->first();
    }

    /**
     * @param $token
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function getEmailForPasswordToken($token)
    {
        $rows = DB::table(config('auth.passwords.users.table'))->get();

        foreach ($rows as $row) {
            if (password_verify($token, $row->token)) {
                return $row->email;
            }
        }

        throw new GeneralException(trans('auth.unknown'));
    }

    /**
     * Create User.
     *
     * @param array $data
     * @param bool  $provider
     *
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $user = self::MODEL;
        $user = new $user();
        $user->first_name = 'Muster';
        $user->last_name = 'Name';
        $user->email = $data['email'];
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->status = 1;
        $user->password = $provider ? null : bcrypt('master2019');
        $user->is_term_accept = true;
        // If users require approval, confirmed is false regardless of account type
        if (config('access.users.requires_approval')) {
            $user->confirmed = 0; // No confirm e-mail sent, that defeats the purpose of manual approval
        } elseif (config('access.users.confirm_email')) { // If user must confirm email
            // If user is from social, already confirmed
            if ($provider) {
                $user->confirmed = 1; // E-mails are validated through the social platform
            } else {
                // Otherwise needs confirmation
                $user->confirmed = 0;
                $confirm = true;
            }
        } else {
            // Otherwise both are off and confirmed is default
            $user->confirmed = 1;
        }

        DB::transaction(function () use ($user) {
            if ($user->save()) {
                /*
                 * Add the default site role to the new user
                 */
                $user->attachRole($this->role->getDefaultUserRole());
                /*
                 * Fetch the permissions of role attached to this user
                */
                $permissions = $user->roles->first()->permissions->pluck('id');
                /*
                 * Assigned permissions to user
                */
                $user->permissions()->sync($permissions);

                $user->storeToken();
            }
        });

        /*
         * If users have to confirm their email and this is not a social account,
         * send the confirmation email
         *
         * If this is a social account they are confirmed through the social provider by default
         */
        if (config('access.users.confirm_email') && false === $provider) {
            $user->notify(new UserNeedsConfirmation($user->confirmation_code));
        }

        /*
         * Return the user object
         */
        return $user;
    }

    /**
     * @param $data
     * @param $provider
     *
     * @throws GeneralException
     *
     * @return UserRepository|bool
     */
    public function findOrCreateSocial($data, $provider)
    {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = $this->findByEmail($user_email);

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (!$user) {
            // Registration is not enabled
            if (!config('access.users.registration')) {
                throw new GeneralException(trans('exceptions.frontend.auth.registration_disabled'));
            }

            $user = $this->create([
                'name'  => $data->name,
                'email' => $user_email,
            ], true);
        }

        // See if the user has logged in with this social account before
        if (!$user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialLogin([
                'provider'    => $provider,
                'provider_id' => $data->id,
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token'  => $data->token,
                'avatar' => $data->avatar,
            ]);
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $token
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function confirmAccount($token)
    {
        $user = $this->findByToken($token);

        if (1 === $user->confirmed) {
            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        if ($user->confirmation_code === $token) {
            $user->confirmed = 1;

            event(new UserConfirmed($user));

            return $user->save();
        }

        throw new GeneralException(trans('exceptions.frontend.auth.confirmation.mismatch'));
    }

    /**
     * @param $id
     * @param $input
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function updateProfile($id, $input)
    {

        try {
            $user = $this->find($id);
            $user->first_name = $input['first_name'];
            $user->last_name = $input['last_name'];
            $user->address = $input['address'];
            $user->country = $input['country'];
            $user->city = $input['city'];
            $user->zip_code = $input['zip_code'];
            $user->updated_by = access()->user()->id;

            if ($user->canChangeEmail()) {
                //Address is not current address
                if ($user->email !== $input['email']) {
                    //Emails have to be unique
                    if ($this->findByEmail($input['email'])) {
                        throw new GeneralException(trans('exceptions.frontend.auth.email_taken'));
                    }

                    // Force the user to re-verify his email address
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed = 0;
                    $user->email = $input['email'];
                    $updated = $user->save();

                    // Send the new confirmation e-mail
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));

                    return [
                        'success'       => $updated,
                        'email_changed' => true,
                    ];
                }
            }

            return $user->save();
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    /**
     * @param $input
     *
     * @throws GeneralException
     *
     * @return mixed
     */
    public function changePassword($input)
    {
        $user = $this->find(access()->id());

        if (Hash::check($input['old_password'], $user->password)) {
            $user->password = bcrypt($input['password']);

            if ($user->save()) {
                $input['email'] = $user->email;
                // Send email to the user
                $options = [
                        'data'                => $input,
                        'email_template_type' => 4,
                    ];
                createNotification('', $user->id, 2, $options);

                return true;
            }
        }

        throw new GeneralException(trans('exceptions.frontend.auth.password.change_mismatch'));
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function saveToken()
    {
        $token = hash_hmac('sha256', Str::random(40), 'hashKey');

        \DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => $token,
        ]);

        return $token;
    }

    /**
     * @param $token
     *
     * @return mixed
     */
    public function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->findByEmail($row->email);
            }
        }

        return false;
    }

    /**
     * @param $latitude
     * @param $longitude
     *
     * @return mixed
     */
    public function scopeCloseTo($latitude, $longitude)
    {
        return $this->query()->whereRaw('
       ST_Distance_Sphere(
            point(longitude, latitude),
            point(?, ?)
        ) * .000621371192 < delivery_max_range
    ', [
            $longitude,
            $latitude,
        ]);
    }

    /**
     * Create new user from Layer.
     *
     * @param array $input
     * @param string $whitelabelId
     *
     * @return UserRepository $user
     */
    public function createUserFromLayer($input, $whitelabelId)
    {
        if ($new_user = $this->findByEmail($input['email'])) {
            $new_user->attachWhitelabel($whitelabelId);
            access()->login($new_user);

            return $new_user;
        }

        $new_user = $this->create($input);
        $new_user->storeToken();
        $new_user->attachWhitelabel($whitelabelId);
        access()->login($new_user);

        return $new_user;
    }
}
