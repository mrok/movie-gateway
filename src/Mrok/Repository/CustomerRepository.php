<?php

namespace Mrok\Repository;

use Symfony\Component\HttpFoundation\Request;
use Mrok\Entity\Movie;

class CustomerRepository extends RepositoryAbstract
{
    /**
     * Obtain data by transferred parameters
     * @param $params - array where key is a name of table column value is searching value
     *
     * @return array
     */

    /**
     * Obtaining logged in user from DB
     * @param string $username
     * @param string $passhash
     *
     * @return mixed bool|array
     */
    public function getLoggedUser($username, $passhash)
    {
        $sql = "SELECT * FROM customer WHERE username = ? AND password = ?";
        $user = $this->dao->fetchAssoc($sql, array($username, $passhash));

        return $user;
    }

    /**
     * @param int $id - customer id
     * @param int $amount - amount to add to counter
     *
     * @return int - number of affected rows
     */
    public function increaseCustomerMovieCounter($id, $amount = 1)
    {

        $sql = "UPDATE customer SET amount = amount + ? WHERE id = ?";
        return $this->dao->executeUpdate($sql, array((int)$amount, $id));
    }

}
