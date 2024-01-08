<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\ContractNft;
use App\Repositories\ContractNftRepository;
use App\Services\S3\S3Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractNftService extends BaseService
{
    protected $s3Service;
    /**
     * Initializing the instances and variables
     *
     * @param ContractNftRepository $contractNftRepository
     */
    public function __construct(ContractNftRepository $contractNftRepository, S3Service $s3Service)
    {
        $this->repository = $contractNftRepository;
        $this->s3Service = $s3Service;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listContractNft($params)
    {
        if (isset($params['sort']) && $params['sort'] == 'selling_price') {
            return $this->repository->sortByOfferSellingPrice($params);
        }
        return $this->list($params);
    }

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function showContractNft($params)
    {
        return $this->show($params, ['contractOffer']);
    }



    /**
     * @param ContractNft $contractNft
     *
     * @return void
     */
    public function delete($contractNft)
    {
        return $this->repository->delete($contractNft);
    }

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listContractNftByUser($id, $params)
    {
        $params['dad_id'] = $id;
        return $this->list($params, ['contractOffer']);
    }

    /**
     * Update model.
     *
     * @param  Model $entity
     * @param  array $data
     *
     * @return  Model
     */
    public function createContractNft($params)
    {
        $url_file = '';
        $filePath = 'images';
        if ($params['image_url']) {
            $url_file = $this->s3Service->upload($params['image_url'], $filePath);
        }

        $params['image_url'] = $url_file;
        $data = $this->repository->createContractNft($params);

        if ($data) {
            $response = json_encode([
                'name' => $data->name,
                'description' => $data->description,
                'image' => $data->image
            ]);

            $nameFile = time(). Str::random(16);
            $result = $this->s3Service->uploadFileS3($nameFile, $response);

            $token_url = Storage::url($result);

            $conditions = [
                'token_url' => $token_url
            ];
            $params = array_merge($conditions, $params);
        }

        return $this->repository->createContractNft($params);
    }
}
