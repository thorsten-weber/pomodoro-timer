<?php

namespace App\Controller;

use Symfony\Component\DependencyInjection\EnvVarLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SoundController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    private string $apiUrl = 'https://freesound.org/apiv2/sounds/';

    private int $soundId = 198841;

    private string $token;

    public function getToken(): string
    {
        return $this->token;
    }

    public function __construct()
    {
        $this->token = $this->getParameter('app.freesound_token');
    }


    public function

    public function fetchAllSoundData(int $soundId = null): Response
    {
        if ($soundId === null) {
            $soundId = $this->soundId;
        }

        $jsonData = file_get_contents(
            $this->buildFetchUrl($this->soundId, $this->getToken())
        );

        $metadata = json_decode($jsonData, true);

//        return new SoundData();
        return $metadata;
    }

    public function buildFetchUrl(int $soundId, string $token): string
    {
         return sprintf($this->apiUrl . "%1d/?fields=name,username,previews&token=%2s", $soundId, $token);
    }
}