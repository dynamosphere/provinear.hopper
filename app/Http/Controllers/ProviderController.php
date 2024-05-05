<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProviderResource;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $service;
    public function __construct(ProviderService $service)
    {
        $this->service = $service;
    }

    /**
     * Activate a provider account for a user
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'exists:users,id|unique:providers,user_id|required|string',
            'portrait' => 'image|mimes:png,jpg|max:2048',
        ]);

        if ($request->hasFile('portrait')){
            $data['portrait_url'] = $this->service->uploadPortrait($request->file('portrait'));
        };
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
