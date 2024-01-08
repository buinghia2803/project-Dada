<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\MailTemplate;

class MailTemplateRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $mailtemplate
     * @return MailTemplateRepository
     */
    public function __construct(MailTemplate $mailTemplate)
    {
        $this->model = $mailTemplate;
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
            case 'subject':
                return $query->where($column, $data);
            case 'content':
                return $query->where($column, $data);
            case 'type':
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
     * Get mail template by type.
     *
     * @param mixed $type.
     * @return mixed
     */
    public function getMailTemplateByType($type)
    {
        return $this->model->where('type', $type)->first();
    }
}
