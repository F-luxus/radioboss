<?php

namespace RadioBoss\Object;

class SongRequest {

    public $filename;
    public $message;

    /**
     * SongRequest constructor.
     * @param $filename
     * @param string $message
     */
    public function __construct($filename, $message = "") {
        $this->filename = $filename;
        $this->message = $message;
    }

    /**
     * Creates a songrequest instance from json.
     * @param array $json
     * @return SongRequest
     */
    public static function fromJson($json) {
        return new self($json["filename"], $json["message"] ?? '');
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

}