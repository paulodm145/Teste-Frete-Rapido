<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Services\CompanyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * @param int $limit
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     * @throws ServiceException
     */
    public function metrics(int $limit = 50)
    {
        $validator = Validator::make(
            ['last_quotes' => $limit],
            ['last_quotes' => 'nullable|integer|min:1']
        );

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        return response($this->companyService->lastQuotes($limit), 200);
    }
}
