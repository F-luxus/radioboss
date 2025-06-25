<?php

namespace RadioBoss\Object;

class Track {

    private $artist;
    private $title;
    private $album;
    private $year;
    private $genre;
    private $comment;
    private $filename;
    private $rating;
    private $duration;
    private $playcount;
    private $lastplayed;
    private $intro;
    private $outro;
    private $bpm;
    private $language;
    private $f1;
    private $f2;
    private $f3;
    private $f4;
    private $f5;
    private $casttitle;
    private $listeners;
    private $starttime;
    private $playlistindex;
    private $index;
    private $ft_idx;
    private $itemtype;

    /**
     * Track constructor.
     * @param $artist
     * @param $title
     * @param $album
     * @param $year
     * @param $genre
     * @param $comment
     * @param $filename
     * @param $rating
     * @param $duration
     * @param $playcount
     * @param $lastplayed
     * @param $intro
     * @param $outro
     * @param $bpm
     * @param $language
     * @param $f1
     * @param $f2
     * @param $f3
     * @param $f4
     * @param $f5
     * @param $casttitle
     * @param $listeners
     * @param $starttime
     * @param $playlistindex
     * @param $index
     * @param $ft_idx
     * @param $itemtype
     */
    public function __construct($artist, $title, $album, $year, $genre, $comment, $filename, $rating, $duration, $playcount, $lastplayed, $intro, $outro, $bpm, $language, $f1, $f2, $f3, $f4, $f5, $casttitle, $listeners, $starttime, $playlistindex, $index, $ft_idx, $itemtype)
    {
        $this->artist = $artist;
        $this->title = $title;
        $this->album = $album;
        $this->year = $year;
        $this->genre = $genre;
        $this->comment = $comment;
        $this->filename = $filename;
        $this->rating = $rating;
        $this->duration = $duration;
        $this->playcount = $playcount;
        $this->lastplayed = $lastplayed;
        $this->intro = $intro;
        $this->outro = $outro;
        $this->bpm = $bpm;
        $this->language = $language;
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;
        $this->f4 = $f4;
        $this->f5 = $f5;
        $this->casttitle = $casttitle;
        $this->listeners = $listeners;
        $this->starttime = $starttime;
        $this->playlistindex = $playlistindex;
        $this->index = $index;
        $this->ft_idx = $ft_idx;
        $this->itemtype = $itemtype;
    }

    /**
     * Creates a track instance from json.
     * @param array $json
     * @return Track
     */
    public static function fromJson($json) {
        return new self($json["ARTIST"] ?? '', $json["TITLE"] ?? '', $json["ALBUM"] ?? '', $json["YEAR"] ?? '', $json["GENRE"] ?? '',
            $json["COMMENT"] ?? '', $json["FILENAME"] ?? '', $json["RATING"] ?? '', $json["DURATION"] ?? '',
            $json["PLAYCOUNT"] ?? '', $json["LASTPLAYED"] ?? '', $json["INTRO"] ?? '', $json["OUTRO"] ?? '', $json["BPM"] ?? '',
            $json["LANGUAGE"] ?? '', $json["F1"] ?? '', $json["F2"] ?? '', $json["F3"] ?? '', $json["F4"] ?? '', $json["F5"] ?? '',
            $json["CASTTITLE"] ?? '', $json["LISTENERS"] ?? '', $json["STARTTIME"] ?? '', $json["PLAYLISTINDEX"] ?? '',
            $json["INDEX"] ?? '', $json["FT_IDX"] ?? '', $json["ITEMTYPE"] ?? ''
            );
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getPlaycount()
    {
        return $this->playcount;
    }

    /**
     * @return mixed
     */
    public function getLastplayed()
    {
        return $this->lastplayed;
    }

    /**
     * @return mixed
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @return mixed
     */
    public function getOutro()
    {
        return $this->outro;
    }

    /**
     * @return mixed
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getF1()
    {
        return $this->f1;
    }

    /**
     * @return mixed
     */
    public function getF2()
    {
        return $this->f2;
    }

    /**
     * @return mixed
     */
    public function getF3()
    {
        return $this->f3;
    }

    /**
     * @return mixed
     */
    public function getF4()
    {
        return $this->f4;
    }

    /**
     * @return mixed
     */
    public function getF5()
    {
        return $this->f5;
    }

    /**
     * @return mixed
     */
    public function getCasttitle()
    {
        return $this->casttitle;
    }

    /**
     * @return mixed
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * @return mixed
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * @return mixed
     */
    public function getPlaylistindex()
    {
        return $this->playlistindex;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed
     */
    public function getFtIdx()
    {
        return $this->ft_idx;
    }

    /**
     * @return mixed
     */
    public function getItemtype()
    {
        return $this->itemtype;
    }

}