<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublicCurrencyController extends Controller
{
    private CurrencyService $currencyService;

    /**
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->currencyService->getCurrencies();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): CurrencyResource
    {
        return $this->currencyService->getCurrency($id);
    }
}
