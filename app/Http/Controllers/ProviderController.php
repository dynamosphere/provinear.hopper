<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProviderResource;
use App\Services\ProviderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProviderController extends Controller
{
    protected $service;
    public function __construct(ProviderService $service)
    {
        $this->service = $service;
    }

    /**
     * Get the current provider
     */
    public function currentProvider(Request $request)
    {
        $provider = $request->user()->provider;
        return new ProviderResource($provider);
    }

    /**
     * Activate a provider account for a user
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'portrait' => 'image|mimes:png,jpg|max:2048',
        ]);

        if ($request->hasFile('portrait')){
            $data['portrait_url'] = $this->service->uploadPortrait($request->file('portrait'));
        };
        $data['user_id'] = $request->user()->user_id;
        if ($this->service->hasProvider($data)){
            return response()->json(['message' => "The provider account has already been activated"], 409);
        }
        $provider = $this->service->activateProvider($data);
        
        return new ProviderResource($provider);
    }


    /**
     * Update the portarit of the provider.
     */
    public function updatePicture(Request $request)
    {
        $request->validate([
            'portrait' => 'image|mimes:png,jpg|max:2048|required',
        ]);
        $provider = $request->user()->provider;
        $image_url = $this->service->updateProviderPicture($provider, $request->file('portrait'));
        if ($image_url){
            return response()->json([
                "message" => "Profile Picture updated successfully",
                "portrait_url" => $image_url
            ]);
        }
        return response()->json([
            "message" => "We could not update your profile picture",
        ], 422);
    }

}
