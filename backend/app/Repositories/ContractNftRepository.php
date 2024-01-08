<?php

namespace App\Repositories;

use App\Models\ContractOffer;
use App\Repositories\BaseRepository;
use App\Models\ContractNft;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ContractNftRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $contractnft
     * @return ContractNftRepository
     */
    public function __construct(ContractNft $contractNft)
    {
        $this->model = $contractNft;
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
            case 'contract_offer_id':
                return $query->where($column, $data);
            case 'address_contract':
                return $query->where($column, $data);
            case 'name':
                return $query->where($column, 'like', '%' . $data . '%');
            case 'image_url':
                return $query->where($column, $data);
            case 'description':
                return $query->where($column, $data);
            case 'token_url':
                return $query->where($column, $data);
            case 'status':
                switch ($data) {
                    case 1:
                        return $query->whereIn('status', [ContractNft::STATUS['wait_for_confirm'], ContractNft::STATUS['approve']]);
                    case 2:
                        return $query->where('status', '=', ContractNft::STATUS['reject']);
                    case 3:
                        return $query->whereIn(
                            'status',
                            [
                                ContractNft::STATUS['approve_opensea'],
                                ContractNft::STATUS['reject_opensea'],
                            ]
                        );
                    case 4:
                        return $query->where('status', '=', ContractNft::STATUS['approve_opensea'])
                            ->whereHas('contractOffer', function ($q) {
                                $q->whereDate('date_end', '<=', Carbon::today()->format('Y-m-d'));
                            });
                    case 5:
                        return $query->where('status', '=', ContractNft::STATUS['approve_opensea'])
                            ->whereHas('contractOffer', function ($q) {
                                $q->where('status', '=', ContractOffer::SOLD_STATUS);
                            });
                    default:
                        return $query;
                }
            case 'token_contract':
                return $query->where($column, $data);
            case 'gas_fee':
                return $query->where($column, $data);
            case 'created_at':
                return $query->where($column, $data);
            case 'updated_at':
                return $query->where($column, $data);
            case 'duration':
                return $query->whereHas('contractOffer', function ($q) use ($data) {
                    if ($data[0]) {
                        $q->whereDate('date_start', '>=', Carbon::parse(str_replace('.', '-', $data[0]))->format('Y-m-d'));
                    }
                    if ($data[1]) {
                        $q->whereDate('date_end', '<=', Carbon::parse(str_replace('.', '-', $data[1]))->format('Y-m-d'));
                    }
                });
            case 'username':
                return $query->where(function ($subQuery) use ($data) {
                    $subQuery->whereHas('contractOffer.dad', function ($q) use ($data) {
                        $q->where('full_name', 'like', '%' . $data . '%');
                    })->orWhereHas('contractOffer.artist', function ($q) use ($data) {
                        $q->where('full_name', 'like', '%' . $data . '%');
                    });
                });
            default:
                return $query;
        }
    }

    /**
     * Query with sort by offer selling price
     *
     * @param $params
     * @return mixed
     */
    public function sortByOfferSellingPrice($params)
    {
        $query = $this->model->select(['*'])
            ->leftJoin('contract_offers', 'contract_offers.id', '=', 'contract_nfts.contract_offer_id');

        if (isset($params['name'])) {
            $query = $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['duration'])) {
            $durationData = $params['duration'];
            if ($durationData[0]) {
                $query = $query->whereDate(
                    'contract_offers.date_start',
                    '>=',
                    Carbon::parse(str_replace('.', '-', $durationData[0]))->format('Y-m-d')
                );
            }
            if ($durationData[1]) {
                $query = $query->whereDate(
                    'contract_offers.date_end',
                    '<=',
                    Carbon::parse(str_replace('.', '-', $durationData[1]))->format('Y-m-d')
                );
            }
        }
        if (isset($params['username'])) {
            $userName = $params['username'];
            $query = $query->where(function ($subQuery) use ($userName) {
                $subQuery->whereHas('contractOffer.dad', function ($q) use ($userName) {
                    $q->where('full_name', 'like', '%' . $userName . '%');
                })->orWhereHas('contractOffer.artist', function ($q) use ($userName) {
                    $q->where('full_name', 'like', '%' . $userName . '%');
                });
            });
        }
        $query = $query->orderBy(
            'contract_offers.selling_price',
            isset($params['sortType']) && $params['sortType'] == 1 ? 'asc' : 'desc'
        );
        $limit = isset($params['limit']) ? (int) $params['limit'] : self::PAGINATE;
        if ($limit) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function createContractNft($params)
    {
        $getTokenContractNft = ContractOffer::select('token')->first();
        $authId = auth()->guard('user_api')->user()->id;
        if($getTokenContractNft){
            if ($params['token_contract_offer'] != $getTokenContractNft->token) {
                return false;
            }
        }
        $contractNft = $this->model->create($params);
        if ($contractNft) {
            $deleteToken = Token::where('token_contract_offer', $params['token_contract_offer'])
            ->where('token_confirm' , $params['token_confirm'])
            ->where('id_artist' , $authId)->first();
            if($deleteToken){
                $deleteToken->delete();
            }
        }
        return $contractNft;
    }
}
