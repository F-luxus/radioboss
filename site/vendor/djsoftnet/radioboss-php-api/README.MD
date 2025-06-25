# RadioBoss PHP Wrapper [![Packagist](https://img.shields.io/packagist/v/djsoftnet/radioboss-php-api.svg)](https://packagist.org/packages/djsoftnet/radioboss-php-api)

This is a PHP wrapper/client for the [RadioBoss API](https://djsoft.net/).

## Table of Contents
1. **[Requirements](#Requirements)**
1. **[Installation](#Installation)**
3. **[General Usage](#General-Usage)**
4. **[Examples](#Examples)**

## Requirements
* PHP 7.2 or later.

## Installation
Install it using [Composer](https://getcomposer.org/):

```sh
composer require djsoftnet/radioboss-php-api
```

## General-Usage
Before using the RadioBoss API, you'll need to enable it in the [RadioBoss Settings](https://manual.djsoft.net/radioboss/en/index.html?remote_control_api.htm).
After you have activated the API and set a password, you can retrieve data.

```php
<?php

require 'vendor/autoload.php';

$client = new \RadioBoss\RadioBossAPIClient("127.0.0.1", "9000");
$api = new \RadioBoss\RadioBossAPI($client);
```

## Examples
- **Track**
  - Get informations from Track Object (Artist, Title, Duration, ...)
    ```php
    $track->getArtist();
    $track->getTitle();
    $track->getDuration();
    ```
  - Get current Track
    ```php
    $api->getPlaybackInfo()->getCurrentTrack();
    ```
  - Get next Track
    ```php
    $api->getPlaybackInfo()->getNextTrack();
    ```
  - Get previous Track
    ```php
    $api->getPlaybackInfo()->getPreviousTrack();
    ```
  - Get last played Songs
    ```php
    //all last played songs
    $api->getLastPlayed();
    //filters out songs that were not sent to the server
    $api->getLastPlayed(true);
    ```
  - Get Artwork of current or next Track
    ```php
    $api->getTrackArtwork();
    $api->getNextTrackArtwork();
    ```
  - Set next Track
    ```php
    $api->setNextTack(123);
    ```
  - Read Track data by filename
    ```php
    $api->readTag("C:\Music\song.mp3");
    ```


- **Playlist**
  - Get data from Playlist Object (Tracks, Track count)
    ```php
    $playlist->getTracks();
    $playlist->getCount();
    ```
  - Get Playlist (provides all information, may be slow for some large Playlists)
    ```php
    //all songs
    $api->getPlaylist();
    //only songs from 5-10
    $api->getPlaylist(5, 10);
    ```
  - Get Playlist (doesn't provide all information)
    ```php
    //all songs
    $api->getPlaylist2();
    //only songs the first 10 songs
    $api->getPlaylist2(10);
    ```

- **Microphone**
  - Get Microphone status
    ```php
    $api->getMicrophone();
    ```
  - Enable/Disable Microphone
    ```php
    $api->setMicrophone(true);
    $api->setMicrophone(false);
    ```


- **Playback**
  - Get data from Playback Object (Position, Length, State, ...)
    ```php
    $playback->getPosition();
    $playback->getLength();
    $playback->getState();
    ```
  - Get Playback Object
    ```php
    $api->getPlaybackInfo()->getPlayback();
    ```


- **Encoder**
  - Get data from Encoder Object (Status, Error, ...)
    ```php
    $encoder->getStatus();
    $encoder->getError();
    ```
  - Get Encoder Object
    ```php
    $api->getEncoderStatus();
    ```
    
- **Player**
  - Get data from Player Object (Version, Uptime)
    ```php
    $player->getVersion();
    $player->getUptime();
    ```
  - Get Player Object
    ```php
    $api->getStatus();
    ```