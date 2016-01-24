# Spotify artist album overview.

Create an overview of artist names and albums.
Use the [Spotify REST API](https://developer.spotify.com/web-api/endpoint-reference/) with provided artists to find related artists and
display them together in a overview with artist name and album.

__Tasks__:

- Retrieve provided artists and extract the artist name and id.
- Retrieve related artists by id and extract the artist name and id.
- Retrieve artists albums previous retrieved artist ids extract album name.
- Create a overview with the following data artist name, album title.

## Run demo

1) Clone the repository
2) Run composer installl.
3) Start webserver.

```
php -S localhost:8888 -t web/
```

## Testing
In the test folder u can find several tests.

## License
The [MIT](http://opensource.org/licenses/MIT "MIT") License (MIT).
