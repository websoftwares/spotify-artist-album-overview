<?php

namespace Websoftwares\Spotify;

class EntityFactory
{
    public static function newArtistEntityInstance()
    {
        return new ArtistEntity();
    }

    public static function newAlbumEntityInstance()
    {
        return new AlbumEntity();
    }
}
