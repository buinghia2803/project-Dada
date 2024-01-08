<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Token;

class TokenRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $token
     * @return TokenRepository
     */
    public function __construct(Token $token)
    {
        $this->model = $token;
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
            case 'id_artist':
                return $query->where($column, $data);
            case 'token_contract_offer':
                return $query->where($column, $data);
            case 'token_confirm':
                return $query->where($column, $data);
            case 'created_at':
                return $query->where($column, $data);
            case 'updated_at':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }

    /**
     * Create model.
     *
     * @param array $data
     *
     * @return Model
     */
    public function createToken($data = [])
    {
        $auth = auth()->guard('user_api')->user();
        switch ($auth->type) {
            case '1':
                return null;
            case '2':
                $token = $this->model->where('token_contract_offer', $data['token_contract_offer'])
                    ->where('id_artist', $auth->id)->first();
                if (!$token) {
                    return $this->model->create($data);
                }
                
                return $token;

        }
    }

    public function listToken($params)
    {
        $authId = auth()->guard('user_api')->user()->id;
        $confirmToken = $this->model->where('token_contract_offer', $params['token_contract_offer'])
            ->where('token_confirm', $params['token_confirm'])
            ->where('id_artist', $authId)->first();
        if($confirmToken){
            return true;
        }

        return false;
    }
}
