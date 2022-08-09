<?php

declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class SoundControllerTest extends KernelTestCase
{
    /**
     *
     */
    public function testBuildFetchUrl(): void
    {

        $sc = new \App\Controller\SoundController();
        dump($sc);
        $this->markTestIncomplete('testBuildFetchUrl incomplete');

        $urlString = $sc->buildFetchUrl(198841, $sc->getToken());
        dump($urlString);
        $this->assertSame("https://freesound.org/apiv2/sounds/198841/?fields=name,username,previews&token=P9ZY4ju10JDxblNeKK6XBX0uxMyleuEqbeznu996", $urlString);
    }

    /**
     * {
     *    "name": "Analog Alarm Clock",
     *    "username": "bone666138",
     *    "previews": {
     *         "preview-lq-ogg": "https://cdn.freesound.org/previews/198/198841_285997-lq.ogg",
     *         "preview-lq-mp3": "https://cdn.freesound.org/previews/198/198841_285997-lq.mp3",
     *         "preview-hq-ogg": "https://cdn.freesound.org/previews/198/198841_285997-hq.ogg",
     *         "preview-hq-mp3": "https://cdn.freesound.org/previews/198/198841_285997-hq.mp3"
     *    }
     * }
     *
     *
     * @return void
     */
    public function testFetchAllSoundData(): void
    {
        $soundData = [
            "name" => "Analog Alarm Clock",
            "username" => "bone666138",
            "previews" => [
                "preview-lq-ogg" => "https://cdn.freesound.org/previews/198/198841_285997-lq.ogg",
                "preview-lq-mp3" => "https://cdn.freesound.org/previews/198/198841_285997-lq.mp3",
                "preview-hq-ogg" => "https://cdn.freesound.org/previews/198/198841_285997-hq.ogg",
                "preview-hq-mp3" => "https://cdn.freesound.org/previews/198/198841_285997-hq.mp3"
            ]
        ];

        $sc = new \App\Controller\SoundController();
        dump($sc);
        $this->markTestIncomplete('testFetchAllSoundData incomplete');
        $scData = $sc->fetchAllSoundData();

        $this->assertSame($soundData, $scData);

    }
}