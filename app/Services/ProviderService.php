<?php

namespace App\Services;

use App\Models\Provider;
use App\Notifications\Enums\TelegramMessageType;
use App\Notifications\TelegramNotification;
use App\Repositories\ProviderRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ProviderService
{
    protected $repository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProviderRepository $repo)
    {
        $this->repository = $repo;
    }

    /**
     * Upload a file and return its url
     */
    public function uploadPortrait($file){
        return $this->repository->uploadPortrait($file);
    }

    /**
     * Check a provider already exists
     */
    public function hasProvider($user_id)
    {
        if ($this->repository->find($user_id)){
            return true;
        }
        return false;
    }

    /**
     * Activate a providers account
     */
    public function activateProvider($data)
    {
        $provider = $this->repository->createProvider($data);
        if ($provider){
            $provider->user->notify(new TelegramNotification(TelegramMessageType::PROVIDER_ACCOUNT_ACTIVATED));
        }
        
        return $provider;
    }

    /***
     * Update providers profile picture
     */
    public function updateProviderPicture(Provider $provider, UploadedFile $file){
        // Check if provider has a profile picture store
        $portrait_path = Storage::path($provider->portrait_url);
        if ($portrait_path && Storage::exists($portrait_path)){
            // Delete the portrait from the server
            Storage::delete($portrait_path);
        }
        // Add new portrait for provider
        $image_url = $this->repository->uploadPortrait($file);
        return $this->repository->updatePicture($provider, $image_url);
    }
}
