<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\PasswordReset;
use App\Repositories\BaseRepository;

class AdminRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $admin
     * @return AdminRepository
     */
    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }


    /**
     * Merge query
     *
     * @param mixed $query
     * @param mixed $column
     * @param mixed $data
     *
     * @return Query
     */
    public function mergeQuery($query, $column, $data)
    {
        switch ($column) {
            case 'type':
                return $query->where($column, $data);
            case 'name':
                return $query->whereRaw("concat(last_name, '', first_name) like '%$data%' ");
            case 'email':
            case 'username':
                return $query->where($column, 'like', '%' . $data . '%');
            default:
                return $query;
        }
    }

    /**
     * @param Admin $admin
     *
     * @return void
     */
    public function updateToken($admin)
    {
        $admin->access_token = $admin->createToken($admin->email)->accessToken;
    }

    /**
     * @param Admin $admin
     * @param array $roles
     *
     * @return void
     */
    public function syncRoles($admin, $roles)
    {
        $admin->syncRoles($roles);
    }

    /**
     * @param Admin $admin
     *
     * @return void
     */
    public function getPermissions($admin)
    {
        $admin->permissions = $admin->getPermissionsViaRoles();
    }

    /**
     * @param mixed $email
     *
     * @return Admin
     */
    public function getActiveUserByEmail($email)
    {
//        return Admin::where(['email' => $email])->whereNotNull('deleted_at')->first();
        return Admin::where(['email' => $email])->first();
    }

    /**
     * @param mixed $email
     *
     * @return string $token
     */
    public function createResetToken($email, $admin)
    {
        $start = \Str::random(4);
        $middle = $admin->id . 'U';
        $end = \Str::random(10 - (strlen($start) + strlen($middle)));
        $token = strtoupper($start . $middle . $end);
        PasswordReset::updateOrCreate(['email' => $email], [
            'token' => $token,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        return $token;
    }

    /**
     * Check token.
     *
     * @param string $token
     * @param string $email
     */
    public function checkToken($token, $email)
    {
        $passwordReset = PasswordReset::where('email', $email)->where('token', $token)->first();
        if ($passwordReset) {
            return $passwordReset;
        }

        return null;
    }

    /**
     * Reset password
     *
     * @param array $conditions
     */
    public function passwordReset($conditions)
    {
        $result = PasswordReset::where('token', $conditions['token'])->first();
        if (isset($result->email)) {
            $admin = $this->model->where('email', $result->email)->first();
            if ($admin) {
                return $admin->update([
                    'password' => bcrypt($conditions['password']),
                ]);
            } else {
                return null;
            }
        }
    }

    /**
     * Remove token.
     *
     * @param string $token
     */
    public function deleteSecretKey($token)
    {
        PasswordReset::where('token', $token)->delete();
    }
}
