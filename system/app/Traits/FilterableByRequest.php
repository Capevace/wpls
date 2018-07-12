<?php

namespace App\Traits;

trait FilterableByRequest
{
    public function scopeFilteredByRequest($query, $request)
    {
        $limit     = $request->input('limit', 25);
        $orderBy   = $request->input('order-by', 'created_at');
        $orderType = $request->input('order-type', 'desc');
        $search    = $request->input('search', '');
        $searchKey = $request->input('search-key', '');


        if (!empty($search)
            && !empty($searchKey)) {
            $query = $query->where($searchKey, 'like', '%' . $search .'%');
        }

        return $query
            ->orderBy($orderBy, $orderType)
            ->paginate($limit);
    }
}