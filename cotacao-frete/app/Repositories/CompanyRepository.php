<?php

namespace App\Repositories;

use App\Exceptions\ServiceException;
use App\Models\Company;
use Illuminate\Database\QueryException;

class CompanyRepository extends BaseRepository
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $limit
     * @return mixed
     * @throws ServiceException
     */
    public function metrics(int $limit = 50)
    {
        try {
            return Company::selectRaw('companies.name as carrier_name,
                    COUNT(quotes.service_id) as quantity_results,
                    SUM(quotes.price) as total_price_shipping,
                    AVG(quotes.price) as average_shipping_price,
                    MIN(quotes.price) as general_cheapest_shipping,
                    MAX(quotes.price) as most_expensive_shipping_overall')
                ->join('services', 'companies.id', '=', 'services.company_id')
                ->join('quotes', 'services.id', '=', 'quotes.service_id')
                ->groupBy('companies.name')
                ->orderBy('total_price_shipping', 'desc')
                ->get();
        } catch (QueryException $e) {
            return throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }
}
