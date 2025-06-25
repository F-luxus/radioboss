<?php

namespace RadioBoss;

use RadioBoss\Exception\APIUnavailableException;
use RadioBoss\Exception\RadioBossException;
use RadioBoss\Exception\UnknownAPIException;
use RadioBoss\Object\Encoder;
use RadioBoss\Object\Playback;
use RadioBoss\Object\Player;
use RadioBoss\Object\Playlist;
use RadioBoss\Object\PlaybackInfo;
use RadioBoss\Object\SongRequest;
use RadioBoss\Object\SongRequests;
use RadioBoss\Object\Track;
use RadioBoss\Util\XMLValidator;

class RadioBossAPI {

    private $client;

    /**
     * RadioBossAPI constructor.
     * @param RadioBossAPIClient $client
     */
    public function __construct($client) {
        $this->client = $client;
    }

    /**
     * Returns the current and next track information, and playback position, state and some other information.
     * @return PlaybackInfo
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getPlaybackInfo() : PlaybackInfo {
        return new PlaybackInfo($this->client->request("playbackinfo"));
    }

    /**
     * Insert a track into the playlist.
     * @param $filename
     * @param $position
     * @param string $streamingtitle
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function insertTrack($filename, $position, $streamingtitle = "") : bool {
        return $this->client->request("inserttrack&filename=" . rawurlencode($filename) . "&pos=" . $position . ($streamingtitle != "" ? ("&streamingtitle=" . $streamingtitle) : "")) == "OK";
    }

    /**
     * Download a music library file (xml).
     * @param $filename
     * @return string
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getLibrary($filename) : string {
        return $this->client->request("library&filename=" . rawurlencode($filename));
    }

    /**
     * Download artwork for the currently playing track (or nothing if there is no artwork).
     * @return string
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getTrackArtwork() : string {
        return $this->client->request("trackartwork");
    }

    /**
     * Download artwork for the next track (or nothing if there is no artwork).
     * @return string
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getNextTrackArtwork() {
        return $this->client->request("nexttrackartwork");
    }

    /**
     * Set the track in the playlist to be played next.
     * @param $position
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function setNextTack($position) {
        return $this->client->request("setnexttrack&pos=" . $position) == "OK";
    }

    /**
     * Delete a track from the playlist.
     * @param $position
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function delete($position) {
        return $this->client->request("delete&pos=" . $position) == "OK";
    }

    /**
     * Move a track to another position in the playlist.
     * @param $oldposition
     * @param $newposition
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function move($oldposition, $newposition) {
        return $this->client->request("move&pos1=" . $oldposition . "&pos2=" . $newposition) == "OK";
    }

    /**
     * Turn the microphone on and off.
     * @param $on
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function setMicrophone($on) {
        return $this->client->request("mic&on=" . ($on ? "1" : "0")) == "OK";
    }

    /**
     * Toggle the microphone on or off.
     * @param $on
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function toggleMicrophone() {
        $status = $this->client->request("mic");
        if($status == 1){
            return "Mikrofonas dabar išjungtas - ". $this->client->request("mic&on=0");
        }
        if($status == 0){
            return "Mikrofonas dabar įjungtas - ". $this->client->request("mic&on=1");           
        }
        //return $this->client->request("mic&on=" . ($on ? "1" : "0")) == "OK";
    }


    /**
     * Query the microphone status.
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getMicrophone() {
        return $this->client->request("mic") == "1";
    }

    /**
     * Returns the playlist contents. This function reads tag information and can be slow for large playlists.
     * @param int $from
     * @param int $to
     * @return Playlist|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getPlaylist($from = -1, $to = -1) {

        if ($from == -1 || $to == -1) {
            $response = $this->client->request("getplaylist");
        } else {
            $response = $this->client->request("getplaylist&from=" . $from . "&to=" . $to);
        }

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        return Playlist::fromJson($response);
    }

    /**
     * Returns the playlist contents. This function is faster than getplaylist.
     * @param int $count
     * @return Playlist|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getPlaylist2($count = -1) {

        $response = $this->client->request("getplaylist2" . ($count != -1 ? ("&cnt=" . $count) : ""));

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        return Playlist::fromJson($response);
    }

    /**
     * Get track information.
     * @param $position
     * @return Track|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getTrackInfo($position) {

        $response = $this->client->request("trackinfo&pos=" . $position);

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        return Track::fromJson($response["Track"]["TRACK"]["@attributes"]);
    }

    /**
     * Adds a song request.
     * @param $filename
     * @param string $message
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function songrequest($filename, $message = "") {
        return $this->client->request("songrequest&filename=" . rawurlencode($filename) . ($message != "" ? ("&message=" . rawurlencode($message)) : "")) == "OK";
    }

    /**
     * Clears the List of the requested songs.
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function clearSongRequests() {
        return $this->client->request("songrequestclear") == "OK";
    }

    /**
     * Clears the List of the requested songs.
     * @return SongRequest[]|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getSongRequestList() {

        $response = $this->client->request("songrequestlist");

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        $requests = array();
        if (array_key_exists("Requests", $response)) {
            if (sizeof($response["Request"]) > 1) {
                foreach ($response["Request"] as $request) {
                    $requests[] = SongRequest::fromJson($request["@attributes"]);
                }
            } else {
                foreach ($response as $request) {
                    $requests[] = SongRequest::fromJson($request["@attributes"]);
                }
            }
        }

        return $requests;
    }

    /**
     * Returns  encoder status information.
     * @return Encoder[]|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getEncoderStatus() {

        $response = $this->client->request("encoderstatus");

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        $encoders = array();
        if (array_key_exists("Encoder", $response)) {
            if (sizeof($response["Encoder"]) > 1) {
                foreach ($response["Encoder"] as $encoder) {
                    $encoders[] = Encoder::fromJson($encoder["@attributes"]);
                }
            } else {
                $encoders[] = Encoder::fromJson($response["Encoder"]["@attributes"]);
            }
        }

        return $encoders;
    }

    /**
     * Returns Stream Archive status.
     * @return int
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getStreamArchiveStatus() {
        return intval($this->client->request("streamarchivestatus"));
    }

    /**
     * Control scheduled events.
     * @param $type
     * @param $event
     * @param $id
     * @param $set
     * @param $skipnext
     * @return string
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function schedule($type, $event, $id, $set, $skipnext) {
        return $this->client->request("schedule&type=" . $type . "&event=" . $event . "&id=" . $id . "&set=" . $set . "&skipnext=" . $skipnext);
    }
    public function scheduleList() {
        return $this->client->request("schedule&type=list");
    }
    public function RunEvent($a) {
        return $this->client->request("schedule&type=run&id=" . $a);
    }
    public function PlayNext() {
        return $this->client->cmd("next");
    }
    /**
     * Returns information about recently played tracks.
     * @param bool $filter
     * @return Track[]|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getLastPlayed($filter = false) {
        $response = $this->client->request("getlastplayed" . ($filter ? "&filter=1" : ""));

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        $tracks = array();
        if (array_key_exists("TRACK", $response)) {
            if (sizeof($response["TRACK"]) > 1) {
                foreach ($response["TRACK"] as $track) {
                    $tracks[] = Track::fromJson($track["@attributes"]);
                }
            } else {
                $tracks[] = Track::fromJson($response["TRACK"]["@attributes"]);
            }
        }

        return $tracks;
    }

    /**
     * Read track tag information.
     * @param $filename
     * @return Track|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function readTag($filename) {
        $response = $this->client->request("readtag&fn=" . rawurlencode($filename));

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        return Track::fromJson(array_change_key_case($response["File"]["@attributes"], CASE_UPPER));
    }

    /**
     * Write track tag information.
     * @param $filename
     * @param $data
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function writeTag($filename, $data) {
        return $this->client->request("writetag&fn=" . rawurlencode($filename) . "&data=" . rawurlencode($data)) == "OK";
    }

    /**
     * Set new title on streaming servers.
     * @param $title
     * @return bool
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function setCastTitle($title) {
        return $this->client->request("setcasttitle&title=" . rawurlencode($title)) == "OK";
    }

    /**
     * Returns RadioBOSS version and uptime in seconds.
     * @return Player|null
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function getStatus() {
        $response = $this->client->request("status");

        if (!XMLValidator::isXMLContentValid($response)) return null;

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        return Player::fromJson($response["Player"]["@attributes"]);
    }

}