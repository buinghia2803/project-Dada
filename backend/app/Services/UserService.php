<?php

namespace App\Services;

use App\Services\BaseService;
use App\Services\Upload\UploadService;
use App\Services\ContractOfferService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param UserRepository $userRepository
     */
    protected $uploadService;
    protected $contractOfferService;

    public function __construct(UserRepository $userRepository, UploadService $uploadService, ContractOfferService $contractOfferService)
    {
        $this->repository = $userRepository;
        $this->uploadService = $uploadService;
        $this->contractOfferService = $contractOfferService;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listUser($params)
    {
        return $this->list($params);
    }

    /**
     * Create new user
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        if (isset($data['image_url']) && !empty($data['image_url'])) {
            $data['image_url'] = $this->uploadService->uploadFile($data['image_url']);
        }

        return $this->repository->create($data);
    }

    /**
     * Get model detail.
     *
     * @param Model $entity
     *
     * @return Model
     */
    public function show(Model $entity, $relations = [])
    {
        $totalContract = $this->repository->totalContractForUser($entity->id);
        $entity->count_contract = $totalContract[0]->count_contract;
        return $entity;
    }

    /**
     * Update user.
     *
     * @param  Model $entity
     * @param  array $data
     *
     * @return  Model
     */
    public function update($entity, $data = [])
    {
        if (isset($data['image_url'])) {
            if ($data['image_url'] != $entity['image_url']) {
                if (is_file($data['image_url'])) {
                    $data['image_url'] = $this->uploadService->uploadFile($data['image_url']);
                    $this->uploadService->removeFile($entity['image_url']);
                }
            }
        } else {
            // delete image
            $this->uploadService->removeFile($entity['image_url']);
        }
        $this->repository->update($entity, $data);

        return $entity;
    }

    /**
     * Update user.
     *
     * @param  Model $entity
     * @param  array $data
     *
     * @return  Model
     */
    public function updateStatus($user, $stautsDelete)
    {
        $params = [
            'status' => $stautsDelete,
        ];
        $this->repository->update($user, $params);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function delete($user)
    {
        $this->uploadService->removeFile($user['image_url']);
        $listContractOffer = $this->contractOfferService->listContractOffer(['dad_or_artist_id' => $user['id']]);

        if (count($listContractOffer) > 0) {
            return ['error' => 'has_contract_offer'];
        }
        return $this->repository->delete($user);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function merge_params($request, $dataCondition)
    {
        return $params = array_merge($request, $dataCondition);
    }

    public function editProfile($user, $request)
    {
        $params = $request->all();
        if ($request->image_url == '') {
            if (!empty($user->image_url)) {
                $this->uploadService->removeFile($user->image_url);
            }
            $params['image_url'] = '';
        }
        if ($request->hasFile('image_url')) {
            if (!empty($user->image_url)) {
                $this->uploadService->removeFile($user->image_url);
            }

            $url = $this->uploadService->uploadFile($request->image_url);
            $params['image_url'] = $url;
        }
        $this->repository->update($user, $params);
        return $user;
    }

    public function updateProfile($user, $params)
    {
        return $this->repository->update($user, $params);
    }

    public function findByUserId()
    {
        return $this->repository->findByUserId();
    }
}
