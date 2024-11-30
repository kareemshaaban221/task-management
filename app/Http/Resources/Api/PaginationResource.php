<?php

/**
 * This file defines the PaginationResource class used within the application.
 *
 * The PaginationResource class extends the JsonResource class and provides
 * functionality to handle paginated resources. It is responsible for converting
 * a paginator instance into a structured array format that includes the data
 * items and pagination details. The class relies on the PaginationDetailsResource
 * to manage and transform pagination-specific data.
 *
 * @category Resources
 * @package  App\Http\Resources\Api
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Http\Resources\Api;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{

    protected array $items;
    protected PaginationDetailsResource $paginationDetailsResource;

    /**
     * Create a new PaginationResource instance.
     *
     * @param \Illuminate\Contracts\Pagination\Paginator $paginator
     */
    public function __construct(Paginator $paginator, string $resourceClass = null) {
        $this->items = $resourceClass ? $paginator->items() : $resourceClass::collection($paginator->items());
        $this->paginationDetailsResource = new PaginationDetailsResource($paginator);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->getData(),
            'pagination_details' => $this->getPaginationDetails(),
        ];
    }

    /**
     * Return the items of the pagination resource.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->items;
    }

    /**
     * Get the pagination details.
     *
     * @return \App\Http\Resources\Api\PaginationDetailsResource
     */
    public function getPaginationDetails(): PaginationDetailsResource
    {
        return $this->paginationDetailsResource;
    }
}
