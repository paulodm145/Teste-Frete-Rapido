<?php

namespace App\Repositories;

use App\Exceptions\ServiceException;
use App\Models\Company;
use App\Models\Quote;
use Illuminate\Database\QueryException;

class QuoteRepository extends BaseRepository
{
    public function __construct(Quote $model)
    {
        parent::__construct($model);
    }
}
