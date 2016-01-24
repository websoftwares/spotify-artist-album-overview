<?php

namespace Websoftwares\Spotify;

use GuzzleHttp\Promise\RejectedPromise;

/**
 * RejectHandler.
 */
class RejectHandler
{
    /**
     * __invoke.
     *
     * @param mixed $error
     *
     * @return RejectedPromise
     */
    public function __invoke($error)
    {
        if ($error instanceof \Exception) {
            $error = $error->getMessage();
        }

        return new RejectedPromise($error);
    }
}
