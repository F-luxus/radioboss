<?php

namespace RadioBoss\Object;

class Playlist {

    private $count;

    /**
     * @var Track[]
     */
    private $tracks;

    /**
     * Playlist constructor.
     * @param $count
     * @param $tracks
     */
    public function __construct($count, $tracks) {
        $this->count = $count;
        $this->tracks = $tracks;
    }

    /**
     * Creates a playlist instance from json.
     * @param array $json
     * @return Playlist
     */
    public static function fromJson($json) {

        $tracks = array();
        if (array_key_exists("TRACK", $json)) {
            if (sizeof($json["TRACK"]) > 1) {
                foreach ($json["TRACK"] as $track) {
                    $tracks[] = Track::fromJson($track["@attributes"]);
                }
            } else {
                $tracks[] = Track::fromJson($json["TRACK"]["@attributes"]);
            }
        }

        return new self(intval($json["@attributes"]["COUNT"] ?? sizeof($tracks)), $tracks);
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

}