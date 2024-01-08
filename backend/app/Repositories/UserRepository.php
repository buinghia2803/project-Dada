<?php

namespace App\Repositories;

use App\Models\ContractNft;
use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\ContractOffer;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $user
     * @return UserRepository
     */
    public function __construct(User $user)
    {
        $this->model = $user;
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
            case 'full_name':
                return $query->where($column, 'like', '%' . $data . '%');
            case 'public_address_main':
                return $query->where($column, $data);
            case 'public_address_sub':
                return $query->where($column, $data);
            case 'status':
                return $query->where($column, $data);
            case 'created_at':
                return $query->where($column, $data);
            case 'updated_at':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }

    public function totalContractForUser($user_id)
    {
        $entities = ContractOffer::select(
            DB::raw('COUNT(id) as count_contract'),
        )->whereHas('contractNft', function ($query) {
            $query->whereIn('contract_nfts.status', [ContractNft::STATUS['approve_opensea'], ContractNft::STATUS['reject_opensea']]);
        })->where(function ($query) use ($user_id) {
            $query->orWhere('contract_offers.dad_id', $user_id)
                ->orWhere('contract_offers.artist_id', $user_id);
        });
        return $entities->get();
    }

    public function findByUserId()
    {
        $dadAuth = auth()->guard('user_api')->user();

        $dadInformation = $this->model->leftJoin('contract_offers', 'users.id', 'contract_offers.dad_id')
            ->leftJoin('contract_nfts', 'contract_offers.id', 'contract_nfts.contract_offer_id')
            ->select(
                'users.*',
                DB::raw('COUNT(DISTINCT contract_offers.id) as count_contract'),
            )
            ->where('contract_offers.dad_id', $dadAuth->id)
            ->whereIn('contract_nfts.status', [ContractNft::STATUS['approve_opensea'], ContractNft::STATUS['reject_opensea']])
            ->groupBy('users.id')
            ->get()->pipe(function ($collection) {
                return collect([
                    'count_contract' => $collection->sum('count_contract'),
                    'id' => $collection->get('id'),
                ]);
            });

        $dadAuth->count_contract = $dadInformation['count_contract'];

        return $dadAuth;
    }
}
