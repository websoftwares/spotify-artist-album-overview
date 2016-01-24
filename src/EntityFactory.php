<?php

namespace Websoftwares\Spotify;

/**
 * EntityFactory.
 */
class EntityFactory
{
    /**
     * newArtistEntityInstance.
     *
     * @return ArtistEntity
     */
    public static function newArtistEntityInstance()
    {
        return new ArtistEntity();
    }

    /**
     * newAlbumEntityInstance.
     *
     * @return AlbumEntity
     */
    public static function newAlbumEntityInstance()
    {
        return new AlbumEntity();
    }
}
