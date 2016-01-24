<?php

namespace Websoftwares\Spotify\test;

use Websoftwares\Spotify\SpotifyClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

/**
 * Class SpotifyClientTest.
 */
class SpotifyClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * spotifyClient.
     *
     * @var SpotifyClient
     */
    protected $spotifyClient;

    /**
     * Setup the test suite.
     */
    public function setUp()
    {
        $this->spotifyClient = new SpotifyClient($this->getGuzzleClientMock());
    }

    /**
     * testGetArtistsAndAlbumsByIdListSucceeds.
     *
     * @param array $artistIdList
     *
     * @dataProvider artistIdListProvider
     */
    public function testGetArtistsAndAlbumsByIdListSucceeds($artistIdList)
    {
        $expected = 'Websoftwares\Spotify\ArtistsAlbumsList';
        $actual = $this->spotifyClient
            ->getArtistsAndAlbumsByIdList($artistIdList);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * testGetArtistsAndAlbumsByIdListFails.
     *
     * @expectedException GuzzleHttp\Promise\RejectionException
     */
    public function testGetArtistsAndAlbumsByIdListFails()
    {
        $badRequest = new RequestException(
            'Error Communicating with Server', new Request('GET', 'test')
        );

        $mock = new MockHandler([$badRequest]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $spotifyClient = new SpotifyClient($client);

        $expected = 'Websoftwares\Spotify\ArtistsAlbumsList';

        $actual = $spotifyClient->getArtistsAndAlbumsByIdList(
            ['6jHG1YQkqgojdEzerwvrVv']
        );

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetArtistsAndAlbumsByIdListFailsInvalidArgumentException()
    {
        $this->spotifyClient->getArtistsAndAlbumsByIdList();
    }

    /**
     * Returns an list of spotify id's.
     *
     * @return array
     */
    public function artistIdListProvider()
    {
        $artistIdlist =  [
            [
                [
                    '6jHG1YQkqgojdEzerwvrVv',
                    '34EP7KEpOjXcM2TCat1ISk',
                    '20qISvAhX20dpIbOOzGK3q',
                    '1Z8ODXyhEBi3WynYw0Rya6',
                    '3Mcii5XWf6E0lrY3Uky4cA',
                    '3CQIn7N5CuRDP8wEI7FiDA',
                    '0eGh2jSWPBX5GuqIHoZJZG',
                    '2gINJ8xw86xawPyGvx1bla',
                    '7B4hKK0S9QYnaoqa9OuwgX',
                    '4Otx4bRLSfpah5kX8hdgDC',
                ],
            ],
        ];

        return $artistIdlist;
    }

    /**
     * Returns a guzzle client instance with configured mock handler and
     * queued responses.
     *
     * @return Client
     */
    private function getGuzzleClientMock()
    {
        $mock = new MockHandler([
            $this->getSeveralArtistsResponse(),
            $this->getRelatedArtistsResponse(),
            $this->getEmptyArtistsAlbumsResponse(),
            $this->getEmptyArtistsAlbumsResponse(),
            $this->getEmptyArtistsAlbumsResponse(),
            $this->getAlbumsResponse(),
            $this->getEmptyArtistsAlbumsResponse(),
            $this->getEmptyArtistsAlbumsResponse(),
            $this->getEmptyArtistsAlbumsResponse(),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    /**
     * Returns the response for get-several-artists request.
     *
     * @return Response
     */
    public function getSeveralArtistsResponse()
    {
        $header =  ['Content-Type' => 'application/json'];
        $protocol = '1.1';
        $status = 200;

        $body = file_get_contents(__DIR__.'/get-several-artists.json');

        $response = new Response($status, $header, $body, $protocol);

        return $response;
    }

    /**
     * Returns the response for empty artists or albums request.
     *
     * @return Response
     */
    public function getEmptyArtistsAlbumsResponse()
    {
        $header =  ['Content-Type' => 'application/json'];
        $protocol = '1.1';
        $status = 200;

        $body = '';

        $response = new Response($status, $header, $body, $protocol);

        return $response;
    }

    /**
     * Returns the response for get-related-artists request.
     *
     * @return Response
     */
    public function getRelatedArtistsResponse()
    {
        $header =  ['Content-Type' => 'application/json'];
        $protocol = '1.1';
        $status = 200;

        $body = file_get_contents(__DIR__.'/get-related-artists.json');

        $response = new Response($status, $header, $body, $protocol);

        return $response;
    }

    /**
     * Returns the response for get-artist-top-tracks request.
     *
     * @return Response
     */
    public function getAlbumsResponse()
    {
        $header =  ['Content-Type' => 'application/json'];
        $protocol = '1.1';
        $status = 200;

        $body = file_get_contents(__DIR__.'/get-artist-top-tracks.json');

        $response = new Response($status, $header, $body, $protocol);

        return $response;
    }
}
