<?php

include __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;
use Websoftwares\Spotify\SpotifyClient;

$client = new Client([
    'base_uri' => 'https://api.spotify.com/v1/',
]);

$spotify = new SpotifyClient($client);
$spotifyArtistIds = [
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
];

$ArtistsAlbumsList = $spotify->getArtistsAndAlbumsByIdList($spotifyArtistIds);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Spotify artist album overview.</title>
</head>
<body>
    <table>
<?php foreach ($ArtistsAlbumsList as $artistId => $artistsAlbums): ?>
	<tr>
        <th><?= $artistsAlbums[0]->name; ?></th>
        <?php foreach ($artistsAlbums[1] as $album): ?>
            <td><?= $album->name; ?></td>
        <?php endforeach;?>
    </tr>
<?php endforeach; ?>
    </table>
<body>
</html>
