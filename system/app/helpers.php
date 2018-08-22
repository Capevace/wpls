<?php

if (!function_exists('filterQueryForDataTable')) {
    function filterQueryForDataTable($query, $request)
    {
        $limit     = (int) $request->input('limit', 25);
        $orderBy   = $request->input('order-by', 'created_at');
        $orderType = $request->input('order-type', 'desc');
        $search    = $request->input('search', '');
        $searchKey = $request->input('search-key', '');#

        if (!empty($search)
            && !empty($searchKey)) {
            $query = $query->where($searchKey, 'like', '%' . $search .'%');
        }

        return $query
            ->orderBy($orderBy, $orderType)
            ->paginate($limit);
    }
}

if (!function_exists('wpls_path')) {
    /**
     * Returns the path to the project (WPLS) root, not the Laravel installation!
     *
     * @param string $path Additional path to extend the wpls_path by.
     * @return string The path.
     */
    function wpls_path($path = '')
    {
        $rootPath = rtrim(realpath(base_path() . '/..'), '\/');
        return $rootPath . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('wpls_version')) {
    /**
     * Returns the installed version of WPLS.
     *
     * @return string The version.
     */
    function wpls_version()
    {
        return \Illuminate\Support\Facades\Storage::disk('general')->exists('installed')
            ? \Illuminate\Support\Facades\Storage::disk('general')->get('installed')
            : '0.0.0';
    }
}