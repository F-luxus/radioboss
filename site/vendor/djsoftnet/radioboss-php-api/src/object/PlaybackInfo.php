<?php

namespace RadioBoss\Object;

class PlaybackInfo {

    /**
     * @var Track
     */
    private $currentTrack;

    /**
     * @var Playback
     */
    private $playback;

    /**
     * @var Options
     */
    private $options;

    /**
     * @var Features
     */
    private $features;

    /**
     * @var Streaming
     */
    private $streaming;

    /**
     * @var Track
     */
    private $previousTrack;

    /**
     * @var Track
     */
    private $nextTrack;

    public $response;

    /**
     * PlaybackInfo constructor.
     * @param string $response
     */
    public function __construct($response) {

        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response,true);

        $this->response = $response;

        $this->currentTrack = Track::fromJson($response["CurrentTrack"]["TRACK"]["@attributes"]);
        $this->playback = Playback::fromJson($response["Playback"]["@attributes"]);
        $this->options = Options::fromJson($response["Options"]["@attributes"]);
        $this->features = Features::fromJson($response["Features"]["@attributes"]);
        $this->streaming = Streaming::fromJson($response["Streaming"]["@attributes"]);
        $this->previousTrack = Track::fromJson($response["PrevTrack"]["TRACK"]["@attributes"]);
        $this->nextTrack = Track::fromJson($response["NextTrack"]["TRACK"]["@attributes"]);

    }

    /**
     * @return Track
     */
    public function getCurrentTrack(): Track
    {
        return $this->currentTrack;
    }

    /**
     * @return Playback
     */
    public function getPlayback(): Playback
    {
        return $this->playback;
    }

    /**
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * @return Features
     */
    public function getFeatures(): Features
    {
        return $this->features;
    }

    /**
     * @return Streaming
     */
    public function getStreaming(): Streaming
    {
        return $this->streaming;
    }

    /**
     * @return Track
     */
    public function getPreviousTrack(): Track
    {
        return $this->previousTrack;
    }

    /**
     * @return Track
     */
    public function getNextTrack(): Track
    {
        return $this->nextTrack;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

}