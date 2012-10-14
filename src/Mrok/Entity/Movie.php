<?php

namespace Mrok\Entity;

class Movie {

    /**
     * @var string
     */
    public $filename;

    /**
     * @var string - ftp, http, sftp
     */
    public $protocol;

    /**
     * @var string
     */
    public $host;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     * if main directory is not a directory with the movie
     */
    public $filePath;

    /**
     * @var string - transferred as a json, tags can describe movie more verbosely
     *  ex user=Mrok externalId=324
     */
    public $tags;

    /**
     * @var int
     */
    public $customerId;

    /**
     * @var int
     */
    public $date;
}