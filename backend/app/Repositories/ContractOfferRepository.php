<?php

namespace App\Repositories;

use App\Models\ContractNft;
use App\Repositories\BaseRepository;
use App\Models\ContractOffer;
use App\Models\Token;
use Carbon\Carbon;

class ContractOfferRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $contractoffer
     * @return ContractOfferRepository
     */
    public function __construct(ContractOffer $contractOffer)
    {
        $this->model = $contractOffer;
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
            case 'many_status':
                return $query->whereIn('status', $data);
            case 'created_at':
                return $query->whereDate(
                    $column,
                    '=',
                    Carbon::parse(str_replace('.', '-', $data))->format('Y-m-d')
                );
            case 'updated_at':
                return $query->where($column, $data);
            case 'dad_id':
                return $query->where($column, $data);
            case 'artist_id':
                return $query->where($column, $data);
            case 'date_start':
                return $query->where($column, $data);
            case 'date_end':
                return $query->where($column, $data);
            case 'selling_price':
                return $query->where($column, $data);
            case 'dad_percent':
                return $query->where($column, $data);
            case 'artist_percent':
                return $query->where($column, $data);
            case 'dad_price':
                return $query->where($column, $data);
            case 'artist_price':
                return $query->where($column, $data);
            case 'system_price':
                return $query->where($column, $data);
            case 'opensea_price':
                return $query->where($column, $data);
            case 'system_percent':
                return $query->where($column, $data);
            case 'opensea_percent':
                return $query->where($column, $data);
            case 'responsibility':
                return $query->where($column, $data);
            case 'contact_info':
                return $query->where($column, $data);
            case 'privacy_policy':
                return $query->where($column, $data);
            case 'terms_contract':
                return $query->where($column, $data);
            case 'accept_privacy_policy':
                return $query->where($column, $data);
            case 'accept_terms_contract':
                return $query->where($column, $data);
            case 'selling_prices':
                return $query->whereBetween('selling_price', $data);
            case 'dad_name':
                return $query->whereHas('dad', function ($q) use ($data) {
                    $q->where('full_name', 'like', '%' . $data . '%');
                });
            case 'status':
                switch ($data) {
                    case 2:
                        return $query->where('status', '=', ContractOffer::WAITING_SIGNING_STATUS);
                    case 3:
                        return $query->whereIn('status', [ContractOffer::EFFECT_STATUS, ContractOffer::SOLD_STATUS]);
                    case 4:
                        return $query->where('status', ContractOffer::EXPIRED_STATUS);
                    case 5:
                        return $query->where('status', ContractOffer::REJECT_STATUS);
                    default:
                        return $query;
                }
            case 'start_date':
                return $query->where('date_start', '>=', $data);
            case 'end_date':
                return $query->where('date_end', '<=', $data);
            case 'dad_or_artist_id':
                return $query->where(function ($q) use ($data) {
                    $q->where('dad_id', $data)
                        ->orWhere('artist_id', $data);
                });
            default:
                return $query;
        }
    }

    /**
     * Get list contract offers need to be updated expired status
     *
     * @return mixed
     */
    public function getExpirationOfferIds() {
        return $this->model->whereHas('contractNft', function ($subQuery) {
                $subQuery->where('status', ContractNft::STATUS['approve_opensea']);
            })
            ->where('status', ContractOffer::EFFECT_STATUS)
            ->whereDate('date_end', '<', Carbon::today()->format('Y-m-d'))
            ->get();
    }

    /**
     * Check token.
     *
     * @param string $token
     * @param string $email
     */
    public function checkOfferEmail($id, $email)
    {
        $contractOfferEmail = $this->model->where('id', $id)->where('email', $email)->first();
        if ($contractOfferEmail) {
            return $contractOfferEmail;
        }

        return null;
    }

    /**
     * Check token.
     *
     * @param string $token
     * @param string $email
     */
    public function getContractOfferByToken($token)
    {
        $contractOffer = $this->model->with('dad')->where('token', $token)->first();
        $countOfferDad = $this->model->where('dad_id', $contractOffer->dad_id)->count();
        if (!$contractOffer) {
            return null;
        }
        $contractOffer->dad->count_offer_dad = $countOfferDad;

        return $contractOffer;
    }

    public function listContractOfferByUser($params, $constant)
    {
        try {
            $query = $this->model->leftJoin('users as user_dad', 'contract_offers.dad_id', 'user_dad.id')
                ->leftJoin('users as user_artist', 'contract_offers.artist_id', 'user_artist.id')
                ->leftJoin('contract_nfts', 'contract_offers.id', 'contract_nfts.contract_offer_id')
                ->select(
                    'contract_offers.*',
                    'contract_nfts.*',
                    'contract_nfts.name as contract_nft_name',
                    'contract_nfts.image_url',
                    'contract_nfts.status as status_contract_nft',
                    'user_dad.full_name as full_name_dad',
                    'user_artist.full_name as full_name_artist'
                )
                ->where('contract_offers.dad_id', $params['id'])
                ->orWhere('contract_offers.artist_id', $params['id'])
                ->whereIn('contract_offers.status', [ContractOffer::EFFECT_STATUS, ContractOffer::SOLD_STATUS]);
            if (isset($params['status_contract']) && $params['status_contract']) {
                switch ($params['status_contract']) {
                        //                    case 1:
                        //                        $query->where('contract_ntfs.status', ContractNft::STATUS['wait_for_confirm'])
                        //                              ->orWhere('contract_ntfs.status', ContractNft::STATUS['approve']);
                        //                        break;
                    case 2:
                        $query->where('contract_ntfs.status', ContractNft::STATUS['wait_for_confirm'])
                            ->orWhere('contract_ntfs.status', ContractNft::STATUS['approve']);
                        break;
                    case 3:
                        $query->where('contract_ntfs.status', ContractNft::STATUS['reject']);
                        break;
                    case 4:
                        $query->where('contract_ntfs.status', ContractNft::STATUS['approve_opensea'])
                            ->orWhere('contract_ntfs.status', ContractNft::STATUS['reject_opensea']);
                        break;
                    case 5:
                        $query->where('contract_ntfs.status', ContractNft::STATUS['approve_opensea'])
                            ->where('contract_offers.status', '!=', ContractOffer::SOLD_STATUS)
                            ->Where('contract_offers.date_public', now()->toDateTimeString());
                        break;
                    case 6:
                        $query->where('contract_ntfs.status', ContractNft::STATUS['approve_opensea'])
                            ->where('contract_offers.status', ContractOffer::SOLD_STATUS);
                        break;
                    default:
                        return $query;
                }
            }
            if (isset($params['keyword']) && $params['keyword']) {
                $query->where('contract_ntfs.name', $params['key_word']);
            }
            if (isset($params['keyword']) && $params['keyword']) {
                $query->where('contract_ntfs.name', $params['key_word']);
            }
            if (isset($params['sort_contract']) && $params['sort_contract']) {
                switch ($params['sort_contract']) {
                    case 1:
                        $query->orderBy('contract_nfts.created_at', $constant['desc']);
                        break;
                    case 2:
                        $query->orderBy('contract_nfts.created_at', $constant['asc']);
                        break;
                    case 3:
                        $query->orderBy('contract_offers.selling_price', $constant['desc']);
                        break;
                    case 4:
                        $query->orderBy('contract_offers.selling_price', $constant['asc']);
                        break;
                    case 5:
                        $query->orderBy('contract_offers.date_start', $constant['desc']);
                        break;
                    case 6:
                        $query->orderBy('contract_offers.date_start', $constant['asc']);
                        break;
                    default:
                        return $query;
                }
            }
            if (isset($params['date_contract']) && $params['date_contract']) {
                if ($params['date_contract']['date_start']) {
                    $query->where('contract_offers.date_start', '>=', $params['date_contract']['date_start']);
                }
                if ($params['date_contract']['date_end']) {
                    $query->where('contract_offers.date_end', '<=', $params['date_contract']['date_end']);
                }
            }
            if (isset($params['selling_price_contract']) && $params['selling_price_contract']) {
                if ($params['selling_price_contract']['from']) {
                    $query->where('contract_offers.date_start', '>=', $params['selling_price_contract']['from']);
                }
                if ($params['selling_price_contract']['to']) {
                    $query->where('contract_offers.date_end', '<=', $params['selling_price_contract']['to']);
                }
            }

            if (isset($params['sort']) && $params['sort']) {
                $query->orderBy($params['sort'], $params['sortType'] ? $constant['asc'] : $constant['desc']);
            }

            return $query->paginate(isset($params['limit']) ? (int) $params['limit'] : $constant['admin_per_page']);
        } catch (\Exception $e) {
        }
    }

    public function updateContractOffer($contractOffer, $params)
    {
        $authId = auth()->guard('user_api')->user()->id;
        $contractOffer->update($params);

        if ($contractOffer) {
            $deleteToken = Token::where('token_contract_offer', $params['token_contract_offer'])
                ->where('token_confirm', $params['token_confirm'])
                ->where('id_artist', $authId)->first();
            if ($deleteToken) {
                 $deleteToken->delete();
            }
        }

        return $contractOffer;
    }
}
