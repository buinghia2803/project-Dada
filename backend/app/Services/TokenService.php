<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\Token;
use App\Repositories\TokenRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TokenService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param TokenRepository $tokenRepository
     */
    public function __construct(TokenRepository $tokenRepository)
    {
        $this->repository = $tokenRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listToken($params)
    {
        return $this->repository->listToken($params);
    }

    /**
     * @param Token $token
     *
     * @return void
     */
    public function delete($token)
    {
        return $this->repository->delete($token);
    }

    /**
     * @param Token $token
     *
     * @return void
     */
    public function create($params)
    {
        $token = time() . Str::random(32);
        $conditions = [
            'id_artist' => auth()->guard('user_api')->user()->id,
            'token_confirm' => $token,
        ];
        $params = array_merge($params, $conditions);

        return $this->repository->createToken($params);
    }
}
