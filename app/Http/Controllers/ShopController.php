<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopResource;
use App\Models\Provider;
use App\Services\ShopService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $service;
    public function __construct(ShopService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all the shops of a vendor.
     */
    public function index(Provider $provider)
    {
        return ShopResource::collection($this->service->providerShops($provider));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
