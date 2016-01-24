<?php

namespace Websoftwares\Spotify;

/**
 * Class ArtistsAlbumsList.
 */
class ArtistsAlbumsList implements \ArrayAccess, \IteratorAggregate
{
    /**
     * $storage.
     *
     * @var array
     */
    private $storage = [];

    /**
     * offsetSet.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->storage[$offset] = $value;
    }

    /**
     * offsetExists.
     *
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->storage[$offset]);
    }

    /**
     * offsetUnset.
     *
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->storage[$offset]);
    }

    /**
     * offsetGet.
     *
     * @param int $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->storage[$offset]) ? $this->storage[$offset] : null;
    }

    /**
     * getIterator.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->storage);
    }
}
