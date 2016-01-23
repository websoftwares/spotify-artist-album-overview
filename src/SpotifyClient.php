<?php

namespace Websoftwares\Spotify;

use GuzzleHttp\Client;

/**
 */
class SpotifyClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor.
     *
     * @param Client $client Instance of the guzzle client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of artist entities.
     *
     * @param array $artistIdList list of spotify id's.
     *
     * @return array Artists list.
     */
    public function getArtistsAndAlbumsByIdList(array $artistIdList = [])
    {
        if (empty($artistIdList)) {
            throw new \InvalidArgumentException('Artist id list is empty.');
        }

        $getSeveralArtists = 'artists?ids='.implode(',', $artistIdList);

        $promise = $this->client
            ->getAsync($getSeveralArtists)
                ->then(
                    new ArtistsHandler(
                        new ArtistsAlbumsList(),
                        $this->client
                    )
                )->then(

                );

        $response = $promise->wait();

        return $response->getArtistsAlbumsList();
    }
}
