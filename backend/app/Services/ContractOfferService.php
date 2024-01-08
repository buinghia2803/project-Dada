<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\ContractOffer;
use App\Repositories\ContractOfferRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Log;
use App\Services\SendMailService;
use Illuminate\Support\Str;

class ContractOfferService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param ContractOfferRepository $contractOfferRepository
     */
    protected $sendMailService;

    public function __construct(
        ContractOfferRepository $contractOfferRepository,
        SettingRepository $settingRepository,
        SendMailService $sendMailService
    ) {
        $this->repository = $contractOfferRepository;
        $this->settingRepository = $settingRepository;
        $this->sendMailService = $sendMailService;
    }

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listContractOffer($params)
    {
        return $this->list($params);
    }

    /**
     * Get list contract.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listContract($id, $params)
    {
        $params['dad_id'] = $id;

        return $this->list($params, ['dad', 'artist']);
    }

    /**
     * Get list contract.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function getContractOfferByToken($token)
    {
        return $this->repository->getContractOfferByToken($token);
    }

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function showContractOffer($params)
    {
        return $this->show($params, ['dad', 'artist']);
    }

    /**
     * @param ContractOffer $contractOffer
     *
     * @return void
     */
    public function delete($contractOffer)
    {
        return $this->repository->delete($contractOffer);
    }

    /**
     * Create contract.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function createContract($params, $decimal, $settingId, $typeSix)
    {
        $params = $this->price($params, $decimal, $settingId, $contractOffer = null);
        if (!$params) {
            return false;
        }
        $createOffer = $this->create($params);
        $token = time() . Str::random(32);
        if ($createOffer) {
            $email = $params['email'];
            $link = config('constant.client_domain') . '/contract/' . $token . '/offer';
            $paramsUrl = ['contract_offer_url' => $link];

            $this->sendMailService->sendMail($typeSix, $email, $paramsUrl);
        }

        return $createOffer;
    }

    /**
     * Update contract.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function updateContract($contractOffer, $params, $decimal, $settingId)
    {
        $params = $this->price($params, $decimal, $settingId, $contractOffer);

        return $this->repository->updateContractOffer($contractOffer, $params);
    }

    /**
     * Get price.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function price($params, $decimal, $settingId, $contractOffer)
    {
        $params['dad_price'] = $this->formula($params['selling_price'], $decimal, $params['dad_percent']);
        $params['artist_price'] = $this->formula($params['selling_price'], $decimal, $params['artist_percent']);

        switch (url()->current()) {
            case route('contract-offer.store'):
                $setting = $this->settingRepository->find($settingId);
                if (!$setting) {
                    return false;
                }
                $params['system_price'] = $this->formula($params['selling_price'], $decimal, $setting->system_percent ?? 0);
                $params['opensea_price'] = $this->formula($params['selling_price'], $decimal, $setting->opensea_percent ?? 0);
                $params['system_percent'] = $setting->system_percent;
                $params['opensea_percent'] = $setting->opensea_percent;
                break;
            case route('contract-offer.update', $contractOffer->id):
                $params['system_price'] = $this->formula($params['selling_price'], $decimal, $contractOffer->system_percent ?? 0);
                $params['opensea_price'] = $this->formula($params['selling_price'], $decimal, $contractOffer->opensea_percent ?? 0);
                break;
        }

        return $params;
    }

    /**
     * Get price.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function formula($selling, $decimal, $percent)
    {
        return $selling * $decimal * $percent;
    }

    /**
     * Get price.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function updateEmail($params)
    {
        $token = time() . Str::random(32);
        $typeSix = 'Send to artist';
        $link = config('constant.client_domain') . '/contract/' . $token . '/offer';
        $this->sendMailService->sendMail($typeSix, $params['email'], $link);

        $params = [
            'email'  => $params['email'],
            'token' => $token,
        ];
        $contractOffer = $this->find($params['id']);

        return $this->update($contractOffer, $params);
    }

    /**
     * Get price.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function checkOfferEmail($id, $email)
    {
        return $this->repository->checkOfferEmail($id, $email);
    }

    public function listContractOfferByUser($params, $constant)
    {
        return $this->repository->listContractOfferByUser($params, $constant);
    }

    /**
     * Get list contract offers need to be updated expired status
     *
     * @return mixed
     */
    public function getExpirationOfferIds() {
        return $this->repository->getExpirationOfferIds();
    }
}
