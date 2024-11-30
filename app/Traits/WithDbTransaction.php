<?php

namespace App\Traits;

use App\Exceptions\Api\ApiBaseException;
use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

trait WithDbTransaction
{

    protected function withDbTransaction(Closure $callback)
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (Throwable $th) {
            DB::rollBack();
            throw new ApiBaseException($th->getMessage(), $th->getTrace());
        }
    }

}
