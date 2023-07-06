<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseService
{
    protected $repository;

    /**
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $dados
     * @return LengthAwarePaginator
     */
    public function getAll($dados)
    {
        $filtersArray = $dados['filters'] ?? [];

        $filters = [];
        $perPage = $dados['per_page'] ?? 20;
        $sortField = $dados['sort_field'] ?? 'id';
        $sortDirection = $dados['sort_direction'] ?? 'asc';

        if (!empty($filtersArray)) {
            foreach ($filtersArray as $filter) {
                //filters[]=nome|like&nome=Gean Carmona
                $parts = explode('|', $filter);
                $field = $parts[0];
                $operator = isset($parts[1]) ? $parts[1] : '=';
                $value = $operator == 'like' ? '%'.$dados[$field].'%': $dados[$field];
                $filters[] = [$field, $operator, $value];
            }
        }

        return $this->repository->getAll($filters, $perPage, $sortField, $sortDirection);
    }


    /**
     * @param int $id
     * @return mixed
     * @throws ServiceException
     */
    public function getById(int $id)
    {
        try {
            return $this->repository->getById($id);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            throw new ServiceException("Erro ao buscar registro: {$e->getMessage()}", 500);
        }
    }


    /**
     * @param array $data
     * @return mixed
     * @throws ServiceException
     */
    public function create(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            throw new ServiceException("Erro ao criar registro: {$e->getMessage()}", 500);
        }
    }


    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws ServiceException
     */
    public function update(int $id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("Registro não encontrado", 404);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            throw new ServiceException("Erro ao atualizar registro: {$e->getMessage()}", 500);
        }
    }


    /**
     * @param int $id
     * @return mixed
     * @throws ServiceException
     */
    public function delete(int $id)
    {
        try {
            return $this->repository->delete($id);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            throw new ServiceException("Erro ao deletar registro: {$e->getMessage()}", 500);
        }
    }

    /**
     * @param array $ids
     * @return mixed
     * @throws ServiceException
     */
    public function massDelete(array $ids)
    {
        try {
            return $this->repository->massDelete($ids);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            throw new ServiceException("Erro ao deletar registro: {$e->getMessage()}", 500);
        }
    }

    public function searchBy($field, $value)
    {
        try {
            return $this->repository->searchBy($field, $value);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            throw new ServiceException("Erro ao deletar registro: {$e->getMessage()}", 500);
        }
    }

}
