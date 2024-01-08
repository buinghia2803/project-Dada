<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\MailTemplate;
use App\Repositories\MailTemplateRepository;
use Illuminate\Support\Facades\Log;

class MailTemplateService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param MailTemplateRepository $mailTemplateRepository
     */
    public function __construct(MailTemplateRepository $mailTemplateRepository)
    {
        $this->repository = $mailTemplateRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listMailTemplate($params)
    {
        return $this->list($params);
    }

    /**
     * @param MailTemplate $mailTemplate
     *
     * @return void
     */
    public function delete($mailTemplate)
    {
        return $this->repository->delete($mailTemplate);
    }

    /**
     * Get mail template by type
     *
     * @param mixed $params
     * @return mixed
     */
    public function getMailTemplateByType($type)
    {
        return $this->repository->getMailTemplateByType($type);
    }
}
