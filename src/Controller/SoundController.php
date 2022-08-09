<?php

namespace App\Controller;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
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

    public function __construct(
        #[Autowire('%app.freesound_token%')] string $token
    )
    {
        $this->token = $token;
    }

    public function showSoundInformations(): Response
    {
        $metadata = $this->fetchAllSoundData();
        dump($metadata);

        return $this->render('sounds.html.twig', [
            'metadata' => $this->fetchAllSoundData(),
        ]);
    }

    public function fetchAllSoundData(int $soundId = null): array
    {
        if ($soundId === null) {
            $soundId = $this->soundId;
        }

        $jsonData = file_get_contents(
            $this->buildFetchUrl($soundId, $this->getToken())
        );

        // return sound metadata;
        return json_decode($jsonData, true);
    }

    public function buildFetchUrl(int $soundId, string $token): string
    {
         return sprintf($this->apiUrl . "%1d/?fields=name,username,previews&token=%2s", $soundId, $token);
    }
}