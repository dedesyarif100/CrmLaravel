<?php

namespace Webkul\TermAndCondition\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\TermAndCondition\Contracts\TermAndCondition as TermAndConditionContract;

class TermAndCondition extends Model implements TermAndConditionContract
{
    protected $table = 'term_and_conditions';

    protected $guarded = 'id';
}
