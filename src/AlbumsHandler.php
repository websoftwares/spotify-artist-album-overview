<?php

namespace Websoftwares\Spotify;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise;

class AlbumsHandler implements ArtistsAlbumsHandlerInterface
{
    private $artistsAlbumsList;
    private $client;

    /**
     * Constructor.
     *
     * @param ArtistsAlbumsList $artistsAlbumsList
     */
    public function __construct(Client $client)
    {
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
        // Get from previous handler the artists albums list.
        $this->artistsAlbumsList = $values->getArtistsAlbumsList();

        $promisses = [];

        // Loop over the artists albums list creating promisses for each artist.
        foreach ($this->artistsAlbumsList as $artistId => $artistAlbum) {
            $artistsTopTracks = 'artists/'.$artistId.'/top-tracks';
            $promisses[$artistId] = $this->client->getAsync($artistsTopTracks);
        }

        // Resolve all promisses.
        $artistAlbums = Promise\unwrap($promisses);

        // Process the result.
        $this->process($artistAlbums);

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
        // Create a new albums list.
        $albumsList = [];

        // Loop over the response values.
        foreach ($values as $artistId => $value) {

            // Decode the json.
            $fetchedAlbums = json_decode((string) $value->getBody());

            // Create an entry even when empty.
            $albumsList[$artistId] = [];

            // Process when not empty.
            if (! empty($fetchedAlbums)) {
                foreach ($fetchedAlbums->tracks as $albumObject) {
                    // Create a new entity instance and asign value to property.
                    $albumEntity = EntityFactory::newAlbumEntityInstance();
                    $albumEntity->name = $albumObject->album->name;

                    // Push onto the list.
                    $albumsList[$artistId][] = $albumEntity;
                }
            }

            // Remove dupes.
            $albumsList[$artistId] = array_unique(
                $albumsList[$artistId],
                SORT_REGULAR
            );

            // The artist entity is currently stored on offset 0.
            $artistEntity = $this->artistsAlbumsList[$artistId][0];

            // Override the offset with Artist and AlbumsList.
            $this->artistsAlbumsList[$artistId] = [
                $artistEntity,
                $albumsList[$artistId],
            ];
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
