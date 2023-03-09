<?php

declare(strict_types=1);

namespace Kernel\Repository\Traits;

use Hyperf\Contract\PaginatorInterface;
use Hyperf\Database\Model\Builder;

trait Searchable
{
    /**
     * Todo: 待完善.
     */
    public function search(array $searchParams, Builder $query = null, array $condition = null): PaginatorInterface
    {
        $perPage = (int) data_get($searchParams, 'per_page', 20);
        $query = $query ?? $this->getQuery();

        return $query->paginate($perPage);
    }
}
