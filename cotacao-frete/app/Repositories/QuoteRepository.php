<?php

namespace App\Repositories;

use App\Models\Quote;

class QuoteRepository extends BaseRepository
{
    public function __construct(Quote $model)
    {
        parent::__construct($model);
    }
}
