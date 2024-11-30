<?php

/**
 * This file defines the PaginationDetailsResource class used within the application.
 *
 * The PaginationDetailsResource class extends the JsonResource class and provides
 * functionality to manage and transform pagination-specific data. It is responsible
 * for converting a paginator or length-aware paginator instance into a structured
 * array format that includes details such as the current page, total pages, items
 * per page, and the total number of items.
 *
 * @category Resources
 * @package  App\Http\Resources\Api
 * @author    Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Http\Resources\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationDetailsResource extends JsonResource
{

    protected $currentPage;
    protected $nextPageUrl;
    protected $path;
    protected $perPage;
    protected $prevPageUrl;
    protected $to = null;
    protected $total = null;

    /**
     * Create a new resource instance.
     *
     * NOTE: we use LengthAwarePaginator here because of total property
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator  $paginator
     * @return void
     */
    public function __construct(Paginator $paginator) {
        $this->currentPage  = $paginator->currentPage();
        $this->nextPageUrl  = $paginator->nextPageUrl();
        $this->path         = $paginator->path();
        $this->perPage      = $paginator->perPage();
        $this->prevPageUrl  = $paginator->previousPageUrl();
        if ($paginator instanceof LengthAwarePaginator) {
            $this->to = min($this->currentPage * $this->perPage, $this->total);
            $this->total = $paginator->total();
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'current_page'  => $this['currentPage'],
            'next_page_url' => $this['nextPageUrl'],
            'path'          => $this['path'],
            'per_page'      => $this['perPage'],
            'prev_page_url' => $this['prevPageUrl'],
            'to'            => $this['to'],
            'total'         => $this['total'],
        ];
    }
}
