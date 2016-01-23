<?php

namespace Websoftwares\Spotify;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise;

class ArtistsHandler implements ArtistsAlbumsHandlerInterface
{
    // Be nice to spotify api endpoint.
    const MAX_THRESHOLD = 3;

    private $artistsAlbumsList;
    private $client;
    private $processedArtistsList = [];
    private $threshold = 0;

    /**
     * Constructor.
     *
     * @param ArtistsAlbumsList $artistsAlbumsList
     * @param Client            $client
     */
    public function __construct(
        ArtistsAlbumsList $artistsAlbumsList,
        Client $client
    ) {
        $this->artistsAlbumsList = $artistsAlbumsList;
        $this->client = $client;
    }

    /**
     * __invoke.
     *
     * @param mixed $values
     *
     * @return $this
     */
    public function __invoke($values)
    {
        $response = json_decode((string) $values->getBody());

        if (empty($response)) {
            return $this;
        }

        $this->process($response);

        $promisses = [];

        foreach ($this->getArtistsAlbumsList() as $artistEntity) {

            if (isset($this->processedArtistsList[$artistEntity->id])
                && $this->processedArtistsList[$artistEntity->id] === true) {
                continue;
            } else {
                $getArtistRelatedArtists = 'artists/'
                    .$artistEntity->id
                    .'/related-artists';

                $promisses[] = $this->client
                    ->getAsync($getArtistRelatedArtists)
                        ->then($this);
                $this->processedArtistsList[$artistEntity->id] = true;
            }
        }

        Promise\unwrap($promisses);

        return $this;
    }

    /**
     * process.
     *
     * @param Response $values
     *
     * @return $this
     */
    private function process($values)
    {
        foreach ($values->artists as $artist) {

            if ($this->threshold >= self::MAX_THRESHOLD) {
                continue;
            }

            $artistEntity = new ArtistEntity();

            $artistEntity->name = $artist->name;
            $artistEntity->id = $artist->id;

            $this->artistsAlbumsList[$artistEntity->id] = $artistEntity;
            $this->processedArtistsList[$artistEntity->id] = false;
            $this->threshold++;
        }

        return $this;
    }

    /**
     * getArtistsAlbumsList.
     *
     * @return ArtistsAlbumsList
     */
    public function getArtistsAlbumsList()
    {
        return $this->artistsAlbumsList;
    }
}
