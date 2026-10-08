# War Music Player

A self-hosted music player for your browser. Drop MP3s into folders, run one script, and
get a searchable player with playlists and cover art.

## Features

- One playlist per folder under `musics/`; MP3s placed directly in `musics/` become
  "Singles".
- Title and artist come from the ID3 tags, or from an `Artist - Title.mp3` file name when
  a song has no tags.
- Cover art comes from the cover embedded in the MP3, else `<song>.jpg` / `<song>.png`
  beside it, else `cover.jpg` / `cover.png` in the folder, else a placeholder.
- Search, shuffle, repeat, volume and mute; Space plays and pauses.
- Media keys and lock-screen controls, through the browser's Media Session API.
- A fullscreen view tinted with the dominant color of the current cover.
- Covers load lazily as you scroll.
- Remembers the current track, position, shuffle, repeat and volume between visits.

## Set up

Needs PHP on the command line (tested with PHP 8.5).

    git clone https://github.com/ArefMozafari/war-music-player.git
    cd war-music-player
    mkdir -p "musics/My Playlist"

Copy your MP3s into `musics/My Playlist/` (one folder per playlist), then build the
track list and serve the folder:

    php tracks.php
    php -S localhost:8000

Open http://localhost:8000. Run `php tracks.php` again whenever you add or remove songs.
It writes `tracks.json`, and saves any embedded covers as image files next to their
songs.

`musics/` and the generated `tracks.json` are listed in `.gitignore`, so your library
never ends up in the repository.

## Third-party code

`getid3/` is [getID3](https://github.com/JamesHeinrich/getID3) 1.9.24 by James Heinrich,
which reads the tags and covers. It is used under its own licenses (GPL, LGPL or MPL; see
`getid3/license.txt`).

## License

The project's own code is MIT — see [LICENSE](LICENSE). `getid3/` keeps its own licenses.
