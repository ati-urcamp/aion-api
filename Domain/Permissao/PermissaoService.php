<?php

namespace Domain\Permissao;

class PermissaoService
{
    protected $repo;

    public function __construct(PermissaoRepository $repo)
    {
        $this->repo = $repo;
    }

    public function search(array $data, array $options = [])
    {
        $model = $this->repo->getModel();

        if (isset($data['nome'])) {
            $model = $model->where(function($query) use ($data) {
                $query->where('nome', 'ilike', '%' . $data['nome'] . '%');
                $query->orWhere('nome_legivel', 'ilike', '%' . $data['nome'] . '%');
            });
        }

        if (isset($options['_with'])) {
            $model = $model->with($options['_with']);
        }

        $orderBy = null;

        if (isset($data['orderBy'])) {
            $orderBy = $data['orderBy'];
        }

        $model = $this->repo->orderByFields($model, $orderBy);

        $limit = isset($options['_limit']) && $options['_limit'] === 'all' ? null : ($options['_limit'] ?? 20);
        $columns = $options['_columns'] ?? ['*'];

        if (!$limit) {
            return $model->get($columns);
        }

        return $model->paginate($limit, $columns, '_page');
    }
}
