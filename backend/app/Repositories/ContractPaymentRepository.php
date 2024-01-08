<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ContractPayment;
use Carbon\Carbon;
use DB;

class ContractPaymentRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $contractpayment
     * @return ContractPaymentRepository
     */
    public function __construct(ContractPayment $contractPayment)
    {
        $this->model = $contractPayment;
    }

    /**
     * Search
     *
     * @param  mixed $query  Query.
     * @param  mixed $column Column.
     * @param  mixed $data   Data.
     *
     * @return mixed
     */
    public function mergeQuery($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where($column, $data);
            case 'created_at':
                $createdAt = Carbon::createFromFormat('Y-m-d', $data)->startOfDay();
                $createdAtE = Carbon::createFromFormat('Y-m-d', $data)->endOfDay();

                return $query->whereBetween($column, [$createdAt, $createdAtE]);
            case 'updated_at':
                return $query->where($column, $data);
            case 'contract_offer_id':
                return $query->where($column, $data);
            case 'contract_nft_id':
                return $query->where($column, $data);
            case 'dad_price':
                return $query->where($column, $data);
            case 'artist_price':
                return $query->where($column, $data);
            case 'status':
                if ((int) $data === -1) {
                    return $query;
                }
                return $query->where($column, $data);
            case 'full_name_dad':
                return $query->whereHas('contractOffer.dad', function ($query) use ($data) {
                    $query->where('users.full_name', 'like', '%' . $data . '%');
                });
            case 'full_name_artist':
                return $query->whereHas('contractOffer.artist', function ($query) use ($data) {
                    $query->where('users.full_name', 'like', '%' . $data . '%');
                });
            default:
                return $query;
        }
    }

    /**
     * List payment
     *
     * @param mixed $params
     * @return mixed
     */
    public function listContractPayment($params, $constant)
    {
        $query = $this->model->leftJoin('contract_offers', 'contract_payments.contract_offer_id', 'contract_offers.id')
            ->leftJoin('users as user_dad', 'contract_offers.dad_id', 'user_dad.id')
            ->leftJoin('users as user_artist', 'contract_offers.artist_id', 'user_artist.id')
            ->leftJoin('contract_nfts', 'contract_payments.contract_nft_id', 'contract_nfts.id')
            ->select(
                'contract_payments.*',
                'contract_nfts.name',
                'contract_nfts.image_url',
                DB::raw('(contract_offers.selling_price - contract_offers.opensea_price) as dividend'),
                'user_dad.full_name as full_name_dad',
                'user_artist.full_name as full_name_artist',
                'contract_offers.selling_price',
            );

        if (isset($params['created_at']) && $params['created_at']) {
            $start = Carbon::createFromFormat('Y-m-d', $params['created_at'])->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $params['created_at'])->endOfDay();

            $query->whereBetween('contract_payments.created_at', [$start, $end]);
        }

        if (isset($params['full_name_dad']) && $params['full_name_dad']) {
            $query->where('user_dad.full_name', 'like', '%' . $params['full_name_dad'] . '%');
        }

        if (isset($params['full_name_artist']) && $params['full_name_artist']) {
            $query->where('user_artist.full_name', 'like', '%' . $params['full_name_artist'] . '%');
        }

        if (isset($params['contract_id']) && $params['contract_id']) {
            $query->where('contract_payments.contract_nft_id', $params['contract_id']);
        }

        if (isset($params['status']) && $params['status'] != null) {
            $query->where('contract_payments.status', $params['status']);
        }

        if (isset($params['sort']) && $params['sort']) {
            $query->orderBy($params['sort'], $params['sortType'] ? $constant['asc'] : $constant['desc']);
        }

        return $query->orderBy('contract_payments.id', $constant['desc'])->paginate(isset($params['limit']) ? (int)$params['limit'] : $constant['admin_per_page']);
    }
}
