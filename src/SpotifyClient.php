<?php

namespace Websoftwares\Spotify;

use GuzzleHttp\Client;

/**
 * Class SpotifyClient.
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
     * @return ArtistsAlbumsList
     */
    public function getArtistsAndAlbumsByIdList(array $artistIdList = [])
    {
        if (empty($artistIdList)) {
            throw new \InvalidArgumentException('Artist id list is empty.');
        }

        $getSeveralArtists = 'artists?ids='.implode(',', $artistIdList);
        $rejectHandler = HandlerFactory::newRejectHandlerInstance();

        $promise = $this->client
            ->getAsync($getSeveralArtists)
                ->then(
                    HandlerFactory::newArtistHandlerInstance($this->client),
                    $rejectHandler
                    )
                ->then(
                    HandlerFactory::newAlbumsHandlerInstance($this->client),
                    $rejectHandler
                );

        $response = $promise->wait();

        return $response->getArtistsAlbumsList();
    }
}
