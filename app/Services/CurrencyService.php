<?php

namespace App\Services;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyService
{

    public function getCurrencies(): AnonymousResourceCollection
    {
        return CurrencyResource::collection(Currency::all());
    }

    public function getCurrency($id): CurrencyResource
    {
        return new CurrencyResource(Currency::findorfail($id));
    }
}
