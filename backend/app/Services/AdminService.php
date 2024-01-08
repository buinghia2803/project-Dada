<?php

namespace App\Services;

use App\Models\Admin;
use App\Services\BaseService;
use App\Repositories\AdminRepository;

class AdminService extends BaseService
{
  /**
   * Initializing the instances and variables
   *
   * @param AdminRepository $adminRepository
   */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->repository = $adminRepository;
    }

  /**
   * ListAdmin
   *
   * @param  mixed $input
   * @return void
   */
    public function listAdmin($params)
    {
        $admins = $this->list($params, ['roles']);

        return $admins;
    }

  /**
   * Update Admin
   *
   * @param  mixed $input
   * @param  mixed $Admin
   *
   * @return mixed
   */
    public function updateAdmin($params, $admin)
    {
      // display hidden password
        $admin = $admin->makeVisible('password');
        $params['password'] = isset($params['password']) ? bcrypt($params['password']) : $admin->password;
      // update Admin
        $admin = $this->update($admin, $params);

        return $admin;
    }

  /**
   * Update token.
   *
   * @param Admin $Admin
   *
   * @return void
   */
    public function updateToken(Admin $admin)
    {
        $this->repository->updateToken($admin);
    }

  /**
   * @param Admin $Admin
   * @param array $roles
   *
   * @return void
   */
    public function syncRoles(Admin $admin, $roles)
    {
        $this->repository->syncRoles($admin, $roles);
    }

    /**
     * Get user by email.
     *
     * @param mixed $email
     *
     * @return Admin
     */
    public function getActiveUserByEmail($email)
    {
        return $this->repository->getActiveUserByEmail($email);
    }

    /**
     * Create token password reset.
     *
     * @param mixed $email
     * @return string $token
     */
    public function createResetToken($email, $admin)
    {
        return $this->repository->createResetToken($email, $admin);
    }

    /**
     * Check token.
     *
     * @param string $token
     * @param string $email
     */
    public function checkToken($token, $email)
    {
        return $this->repository->checkToken($token, $email);
    }

    /**
     * Reset password
     *
     * @param array $conditions
     */
    public function passwordReset($conditions)
    {
        return $this->repository->passwordReset($conditions);
    }

    /**
     * Remove token.
     *
     * @param string $token
     */
    public function deleteSecretKey($token)
    {
        return $this->repository->deleteSecretKey($token);
    }
}
