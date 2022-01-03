<?php

namespace Webkul\TermAndCondition\Repositories;

use Webkul\Core\Eloquent\Repository;

class TermAndConditionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\TermAndCondition\Contracts\TermAndCondition';
    }
}