<?php

namespace App\Repositories;

use App\Models\Provider;

class ProviderRepository
{
    protected $provider;
    /**
     * Create a new class instance.
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Upload a file and return its url
     */
    public function uploadPortrait($file){
        $path = $this->provider->uploadFile($file, $this->provider->uploadDir);
        return $this->provider->getFileUrl($path);
    }

    /***
     * Update the portrait of a provider
     */
    public function updatePicture(Provider $provider, $portrait_url){
        if($provider && $portrait_url){
            $provider->portrait_url = $portrait_url;
            if ($provider->save()){
                return $$provider->portrait_url;
            }
        }
        return null;
    }

    /**
     * Create a new provider
     */
    public function createProvider($data){
        if ($data){
            return $this->provider->create($data);
        }
        return null;
    }
}
