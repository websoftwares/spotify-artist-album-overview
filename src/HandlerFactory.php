<?php

namespace Websoftwares\Spotify;

use GuzzleHttp\Client;

/**
 * HandlerFactory.
 */
class HandlerFactory
{
    /**
     * Returns a new instance.
     *
     * @param Client $client
     *
     * @return ArtistsHandler
     */
    public static function newArtistHandlerInstance(Client $client)
    {
        return new ArtistsHandler(new ArtistsAlbumsList(), $client);
    }

    /**
     * Returns a new instance.
     *
     * @param Client $client
     *
     * @return AlbumsHandler
     */
    public static function newAlbumsHandlerInstance(Client $client)
    {
        return new AlbumsHandler($client);
    }

    /**
     * Returns a new instance.
     *
     * @return RejectHandler
     */
    public static function newRejectHandlerInstance()
    {
        return new RejectHandler();
    }
}
