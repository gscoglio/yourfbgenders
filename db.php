<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';

class DataBase
{
    private $_db;

    public function __construct() {
        if (!($link = mysql_connect("localhost", "root", "root"))) {
            echo "Error conecting to data base";
            exit();
        }
        if (!mysql_select_db("yourfbgenders", $link)) {
            echo "Error selecting data base";
            exit();
        }
        $this->_db = $link;
    }

    public function saveUser($bind) {
        if ($this->userExists($bind['user_id'])) {
            $this->_updateUser($bind);
        } else {
            $this->_insertNewUser($bind);
        }
    }

    private function _insertNewUser($params) {

        $sql = "INSERT INTO user_data (user_id, name, first_name, last_name, link,
    username, gender, locale, male_count, female_count, unknown_friends_amount,
    total_friends, female_perc, male_perc, unknown_perc, access_token, published) values(" .
                $params['user_id'] . "," .
                "'" . addslashes($params['name']) . "'," .
                "'" . addslashes($params['first_name']) . "'," .
                "'" . addslashes($params['last_name']) . "'," .
                "'" . $params['link'] . "'," .
                "'" . $params['username'] . "'," .
                "'" . $params['gender'] . "'," .
                "'" . $params['locale'] . "'," .
                $params['male_count'] . "," .
                $params['female_count'] . "," .
                $params['unknown_friends_amount'] . "," .
                $params['total_friends'] . "," .
                $params['female_perc'] . "," .
                $params['male_perc'] . "," .
                $params['unknown_perc'] . "," .
                "'" . $params['access_token'] . "'," .
                $params['published'] .
                ");";

        $query = mysql_query($sql, $this->_db)
                or die("Error inserting data in data base");
    }

    public function saveLastUser($user_id) {
        $sql = "UPDATE last_user SET user_id=$user_id;";
        $query = mysql_query($sql, $this->_db)
                or die("Error inserting data in data base");
    }

    private function _updateUser($params) {

        $sql = "UPDATE user_data SET
        name = '" . addslashes($params['name']) . "',
        first_name = '" . addslashes($params['first_name']) . "',
        last_name = '" . addslashes($params['last_name']) . "',
        link = '{$params['link']}',
        username = '{$params['username']}',
        gender = '{$params['gender']}',
        locale = '{$params['locale']}',
        male_count = {$params['male_count']},
        female_count = {$params['female_count']},
        unknown_friends_amount = {$params['unknown_friends_amount']},
        total_friends = {$params['total_friends']},
        female_perc = {$params['female_perc']},
        male_perc = {$params['male_perc']},
        unknown_perc = {$params['unknown_perc']},
        access_token = '{$params['access_token']}',
        published = {$params['published']}
        WHERE user_id = {$params['user_id']};";

        $query = mysql_query($sql, $this->_db)
                or die("Error updating user data");
    }

    public function fetchUserById($user_id) {
        $user_id_escaped = mysql_real_escape_string($user_id);
        $sql = "SELECT * FROM user_data WHERE user_id = " 
            . $user_id_escaped . " LIMIT 1;"
        ;
        $query = mysql_query($sql, $this->_db);
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function fetchLastUser() {
        $sql = "SELECT * FROM last_user;";
        $query = mysql_query($sql, $this->_db);
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function amountOfUsers() {
        $sql = "SELECT count(*) FROM user_data;";
        $query = mysql_query($sql, $this->_db);
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function fetchUserByUserName($username) {
        $username_escaped = mysql_real_escape_string($username);
        $sql = "SELECT * FROM user_data WHERE username = '" 
            . $username_escaped . "' ORDER BY id DESC LIMIT 1;"
        ;
        $query = mysql_query($sql, $this->_db);
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function userExists($user_id) {
        $user_id_escaped = mysql_real_escape_string($user_id);
        $sql = "SELECT count(*) AS amount FROM user_data WHERE user_id = " 
            . $user_id_escaped . ";"
        ;
        $query = mysql_query($sql, $this->_db);
        $result = mysql_fetch_array($query);

        if ($result['amount'] > 0) {
            return true;
        }

        return false;
    }

    public function usernameExists($username) {
        $username_escaped = mysql_real_escape_string($username);
        $sql = "SELECT count(*) AS amount FROM user_data WHERE username = '" 
            . $username_escaped . "';"
        ;
        $query = mysql_query($sql, $this->_db);
        $result = mysql_fetch_array($query);

        if ($result['amount'] > 0) {
            return true;
        }

        return false;
    }

    public function fetchUsers($page, $amount) {
        $sql = "SELECT * FROM user_data LIMIT " . ($page - 1) * $amount 
            . "," . $amount . ";"
        ;
        $query = mysql_query($sql, $this->_db);
        while ($result = mysql_fetch_array($query)) {
            $users[] = $result;
        }
        return $users;
    }

}