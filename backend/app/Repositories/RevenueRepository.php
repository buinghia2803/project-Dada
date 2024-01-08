<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ContractOffer;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\ContractOfferRepository;
use Illuminate\Support\Facades\DB;

class RevenueRepository extends BaseRepository
{
    /**
     * ContractOfferRepository
     *
     * @var mixed
     */
    protected $contractOfferRepository;

    /**
     * UserRepository
     *
     * @var mixed
     */
    protected $userRepository;

    /**
     * ModelUser
     *
     * @var mixed
     */
    protected $modelUser;

    /**
     * Initializing the instances and variables
     *
     * @param Model $revenue
     * @param Model $user
     * @return RevenueRepository
     */
    public function __construct(
        ContractOffer $contractOffer,
        User $user,
        UserRepository $userRepository,
        ContractOfferRepository $contractOfferRepository
    )
    {
        $this->model = $contractOffer;
        $this->modelUser = $user;
        $this->userRepository = $userRepository;
        $this->contractOfferRepository = $contractOfferRepository;
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
            default:
                return $query;
        }
    }

    /**
     * SumData
     *
     * @param  mixed $params
     * @param  mixed $relations
     * @return void
     */
    public function sumData($params, $relations = [])
    {
        $params = collect($params);
        $entities = $this->model
        ->leftJoin('users as user_dad', 'user_dad.id', '=', 'contract_offers.dad_id')
        ->leftJoin('users as user_artist', 'user_artist.id', '=', 'contract_offers.artist_id')
        ->leftJoin('contract_payments', 'contract_offers.id', '=', 'contract_payments.contract_offer_id')
        ->select(
            DB::raw('IF(contract_offers.dad_id = user_dad.id, SUM(DISTINCT contract_offers.dad_price), 0)
             + IF(contract_offers.artist_id = user_artist.id, SUM(DISTINCT contract_offers.artist_price), 0)
             + (IF(contract_offers.dad_id = user_dad.id, SUM(DISTINCT contract_offers.opensea_price), 0)
             + IF(contract_offers.dad_id = user_dad.id, SUM(DISTINCT contract_offers.system_price), 0)) as sum_total_price'),
            DB::raw('COUNT(contract_offers.id) as count_contract'),
            DB::raw('IF(contract_offers.dad_id = user_dad.id, SUM(DISTINCT contract_offers.dad_price), 0) as sum_price_dad'),
            DB::raw('IF(contract_offers.artist_id = user_artist.id,
             SUM(DISTINCT contract_offers.artist_price), 0) as sum_price_artist'),
            DB::raw('IF(contract_offers.dad_id = user_dad.id,
            SUM(DISTINCT contract_offers.opensea_price), 0)
            + IF(contract_offers.dad_id = user_dad.id, SUM(DISTINCT contract_offers.system_price), 0) as sum_price_system')
        )
        ->where('contract_offers.status', $params['status'])

        ->where(function ($query) use ($params) {
            if (isset($params['full_name']) && $params['full_name']) {
                $query->where('user_dad.full_name', 'like', '%' . $params['full_name'] . '%')
                ->orWhere('user_artist.full_name', 'like', '%' . $params['full_name'] . '%');
            }
        });

        if (isset($params['month']) && isset($params['year'])) {
            $entities->whereMonth('contract_payments.created_at', $params['month'])
                     ->whereYear('contract_payments.created_at', $params['year']);
        }

        $entities->groupBy('contract_offers.id');
        $result = $entities->get()->pipe(function ($collection) {
            return collect([
              'sum_total_price' => $collection->sum('sum_total_price'),
              'count_contract' => $collection->sum('count_contract'),
              'sum_price_dad' => $collection->sum('sum_price_dad'),
              'sum_price_artist' => $collection->sum('sum_price_artist'),
              'sum_price_system' => $collection->sum('sum_price_system'),
            ]);
        });

        return $result;
    }

    /**
     * CountDataUser
     *
     * @param  mixed $params
     * @param  mixed $relations
     * @return void
     */
    public function countDataUser($params)
    {
        $params = collect($params);
        $entities = $this->modelUser->leftJoin('contract_offers as contract_dad', 'users.id', '=', 'contract_dad.dad_id')
            ->leftJoin('contract_offers as contract_artist', 'users.id', '=', 'contract_artist.artist_id')
            ->leftJoin('contract_payments as payment_dad', 'contract_dad.id', '=', 'payment_dad.contract_offer_id')
            ->leftJoin('contract_payments as payment_artist', 'contract_artist.id', '=', 'payment_artist.contract_offer_id')
            ->select(
                'users.*',
                DB::raw('IF(contract_dad.dad_id = users.id, SUM(DISTINCT contract_dad.dad_price), 0)
                 + IF(contract_artist.artist_id = users.id, SUM(DISTINCT contract_artist.artist_price), 0)
                 + (IF(contract_dad.dad_id = users.id, SUM(DISTINCT contract_dad.opensea_price), 0)
                 + IF(contract_dad.dad_id = users.id, SUM(DISTINCT contract_dad.system_price), 0)) as sum_total_price'),
                DB::raw('IF(contract_dad.dad_id = users.id, COUNT(DISTINCT contract_dad.id), 0)
                 + IF(contract_artist.artist_id = users.id, COUNT(DISTINCT contract_artist.id), 0) as count_contract'),
                DB::raw('IF(contract_dad.dad_id = users.id, SUM(DISTINCT contract_dad.dad_price), 0) as sum_price_dad'),
                DB::raw('IF(contract_artist.artist_id = users.id, SUM(DISTINCT contract_artist.artist_price), 0) as sum_price_artist'),
                DB::raw('IF(contract_dad.dad_id = users.id, SUM(DISTINCT contract_dad.opensea_price), 0)
                 + IF(contract_dad.dad_id = users.id, SUM(DISTINCT contract_dad.system_price), 0) as sum_price_system')
            )
            ->where(function ($query) use ($params) {
                $query->where('contract_dad.status', $params['status'])->orWhere('contract_artist.status', $params['status']);
            });

        if (isset($params['full_name']) && $params['full_name']) {
            $entities->where('users.full_name', 'like', '%' . $params['full_name'] . '%');
        }

        if (isset($params['month']) && isset($params['year'])) {
            $entities->where(function ($query) use ($params) {
                $query->whereMonth('payment_artist.created_at', $params['month'])
                      ->whereYear('payment_artist.created_at', $params['year']);
            });

            $entities->orwhere(function ($query) use ($params) {
                $query->whereMonth('payment_dad.created_at', $params['month'])->whereYear('payment_dad.created_at', $params['year']);
            });
        }

            $entities->groupBy('users.id');

        // Order list
        $orderBy = $params->has('sort') ? $params['sort']
            : $this->modelUser->getKeyName();
        // dd($orderBy);
        $entities = $entities->orderBy($orderBy, $params->has('sortType') && $params['sortType'] == 1 ? 'asc' : 'desc');

        // // Limit result
        $limit = $params->has('limit') ? (int) $params['limit'] : self::PAGINATE;
        if ($limit) {
            return $entities->paginate($limit);
        }

        return $entities->get();
    }
}
