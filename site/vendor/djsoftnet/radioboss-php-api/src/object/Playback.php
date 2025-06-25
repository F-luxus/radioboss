<?php

namespace RadioBoss\Object;

class Playback {

    private $position;
    private $length;
    private $state;
    private $playlistpos;

    /**
     * Playback constructor.
     * @param $position
     * @param $length
     * @param $state
     * @param $playlistpos
     */
    public function __construct($position, $length, $state, $playlistpos) {
        $this->position = $position;
        $this->length = $length;
        $this->state = $state;
        $this->playlistpos = $playlistpos;
    }

    /**
     * Creates a track instance from json.
     * @param array $json
     * @return Playback
     */
    public static function fromJson($json) {
        return new self($json["pos"], $json["len"], $json["state"], $json["playlistpos"]);
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getPlaylistpos()
    {
        return $this->playlistpos;
    }

}