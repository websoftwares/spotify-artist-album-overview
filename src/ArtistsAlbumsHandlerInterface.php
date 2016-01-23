<?php

namespace Websoftwares\Spotify;

/**
 * Interface ArtistsAlbumsHandlerInterface.
 */
interface ArtistsAlbumsHandlerInterface
{
    /**
     * __invoke.
     *
     * @param mixed $values
     *
     * @return $this
     */
    public function __invoke($values);

    /**
     * getArtistsAlbumsList.
     *
     * @return ArtistsAlbumsList
     */
    public function getArtistsAlbumsList();
}
