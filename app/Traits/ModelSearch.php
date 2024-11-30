<?php

/**
 * This file defines the ModelSearch trait used within the application.
 *
 * The ModelSearch trait provides utility methods for applying search filters
 * to queries, allowing for dynamic filtering of data based on various criteria.
 * It can be utilized across different models to enable consistent and reusable
 * filtering logic.
 *
 * @category Traits
 * @package  App\Traits
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ModelSearch
{

    /**
     * @param Builder $query
     * @param mixed $searchToken
     */
    public function scopeSearch($query, $searchToken)
    {
        $query->whereAny($this->searchFields, 'like', '%' . $searchToken . '%');
    }

}
