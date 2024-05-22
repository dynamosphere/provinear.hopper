<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Provider;
use App\Models\Shop;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * @tags Provider
 */
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
    public function index(Request $request, Provider $provider)
    {
        Gate::authorize('view', $provider);

        $provider = $request->user()->provider;
        return ShopResource::collection($this->service->providerShops($provider));
    }

    /**
     * Create a new shop for the current authenticated provider.
     * 
     * @requestMediaType multipart/form-data
     */
    public function store(ShopRequest $request, Provider $provider)
    {
        Gate::authorize('createShop', $provider);

        // if($this->service->canCreateStore($provider)){
            $data = $request->validated();
            $data['brand_logo_url'] = $this->service->uploadBrandLogo($request);
            $data['brand_cover_image_url'] = $this->service->uploadBrandCoverImage($request);
            $data['provider_id'] = $provider->provider_id;
            $shop = $this->service->newShop($data);

            return new ShopResource($shop);
        // }
        // return response()->json(['message' => 'You are not allowed to create a shop'], 403);
    }

    /**
     * Get a shop using it's id
     */
    public function show(Shop $shop)
    {
        Gate::authorize('view', $shop);

        return new ShopResource($shop);
    }

    /**
     * Update the specified shop using the shop id.
     */
    public function update(ShopRequest $request, Shop $shop)
    {
        Gate::authorize('update', $shop);
        
        $data = $request->validated();
        $updatedShop = $this->service->updateShop($shop, $data);
        return new ShopResource($updatedShop);
    }

    /**
     * Update the cover image of a shop
     */
    public function updateCoverImage(Request $request, Shop $shop)
    {
        Gate::authorize('update', $shop);

        $request->validate([
            'brand_cover_image' => 'image|mimes:png,jpg|size:2048|required',
        ]);
        $data = ['brand_cover_image_url' => $this->service->uploadBrandCoverImage($request) ];
        $updatedShop = $this->service->updateShop($shop, $data);
        return new ShopResource($updatedShop);
    }

    /**
     * Update a shop's logo
     */
    public function updateLogo(Request $request, Shop $shop)
    {
        Gate::authorize('update', $shop);

        $request->validate([
            'brand_logo' => 'image|mimes:png,jpg|size:2048|required',
        ]);
        $data = ['brand_logo_url' => $this->service->uploadBrandLogo($request) ];
        $updatedShop = $this->service->updateShop($shop, $data);
        return new ShopResource($updatedShop);
    }

    /**
     * Delete a shop.
     */
    public function destroy(Shop $shop)
    {
        Gate::authorize('delete', $shop);

        if ($this->service->deleteShop($shop))
        {
            return response()->json([
                'message' => 'Shop deleted successfully'
            ], 204);
        }

    }
}
