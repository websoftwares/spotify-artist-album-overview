<?php
namespace Websoftwares\Spotify;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Client;
use Websoftwares\Spotify\ArtistAlbumCollection;

/**
 * @package Websoftwares\Spotify;
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
     * @param  array $artistIdList list of spotify id's.
     *
     * @return array Artists list.
     */
    public function getArtistsAndAlbumsByIdList(array $artistIdList = [])
    {
        if (empty($artistIdList))
        {
            throw new \InvalidArgumentException('Artist id list is empty.');
        }

        $getSeveralArtists = 'artists?ids=' . implode(',', $artistIdList);

        $promise = $this->client
            ->getAsync($getSeveralArtists);

        $response = $promise->wait();
        return json_decode((string) $response->getBody());
    }
}
