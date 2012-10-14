<?php

namespace Mrok\Repository;

use Symfony\Component\HttpFoundation\Request;
use Mrok\Entity\Movie;

class MovieRepository extends RepositoryAbstract
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

    /**
     * Persist entity in DB
     * @param \Mrok\Entity\Movie $movie
     *
     * @return true/false
     */
    public function persist(Movie $movie)
    {
        $data = (array)$movie;
        $data['customer_id'] = $data['customerId'];
        if (empty($data['date'])) {
            $data['date'] = date('Y-m-d H:i:s');
        }

        $columns = array('customer_id', 'filename', 'date', 'tags');
        $data = array_intersect_key($data, array_combine($columns, $columns));

        $this->dao->insert('movie', $data);
    }
}