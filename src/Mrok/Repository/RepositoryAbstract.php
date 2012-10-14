<?php
namespace Mrok\Repository;

abstract class RepositoryAbstract
{
    /**
     * @var Doctrine\DBAL\Connection.
     */
    protected $dao;

    /**
     * @abstract
     * Setup DAO object
     *
     * @param $dao
     *
     * @return RepositoryAbstract
     */
    public function setDAO($dao)
    {
        $this->dao = $dao;
        return $this;
    }

}