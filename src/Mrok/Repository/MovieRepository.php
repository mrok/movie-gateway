<?php

namespace Mrok\Repository;

use Symfony\Component\HttpFoundation\Request;
use Mrok\Entity\Movie;

class MovieRepository
{

    /**
     * Setup entity based on request parameters
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Mrok\Entity\Movie
     */
    public function createFromRequest(Request $request)
    {
        $entity = new Movie();

        $entity->protocol = $request->get('protocol');
        $entity->host = $request->get('host');
        $entity->username = $request->get('username');
        $entity->password = $request->get('password');
        $entity->filePath = $request->get('filePath');
        $entity->filename = $request->get('filename');
        $entity->tags = $request->get('tags');

        return $entity;
    }


}
