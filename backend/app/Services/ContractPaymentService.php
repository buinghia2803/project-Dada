<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\ContractPayment;
use App\Repositories\ContractPaymentRepository;
use Illuminate\Support\Facades\Log;

class ContractPaymentService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param ContractPaymentRepository $contractPaymentRepository
     */
    public function __construct(ContractPaymentRepository $contractPaymentRepository)
    {
        $this->repository = $contractPaymentRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listContractPayment($params, $constant)
    {
        return $this->repository->listContractPayment($params, $constant);
    }

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function showContractPayment($params)
    {
        return $this->show($params, ['contractOffer', 'contractNft']);
    }

    /**
     * @param ContractPayment $contractPayment
     *
     * @return void
     */
    public function delete($contractPayment)
    {
        return $this->repository->delete($contractPayment);
    }
}
