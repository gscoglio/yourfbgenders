<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';

function Conectarse() {

    //global $database;

    //$db_name = $GLOBALS['database']['db_name'];
    //$db_username = $GLOBALS['database']['db_username'];
    //$db_password = $GLOBALS['database']['$db_password'];

    if (!($link = mysql_connect("mysql.yourfbgenders.com", "yourfbgenders", "urfbgenders"))) {
        echo "Error conecting to data base";
        exit();
    }
    if (!mysql_select_db("yourfbgenders", $link)) {
        echo "Error selecting data base";
        exit();
    }
    return $link;
}

function InsertNewUser($user_id, $name, $first_name, $last_name, $link, $username, $gender, $locale, $male_count, $female_count, $unknown_friends_amount, $total_friends, $female_perc, $male_perc, $unknown_perc, $access_token, $published) {

    $conection = Conectarse();

    $sql = "INSERT INTO user_data (user_id, name, first_name, last_name, link,
    username, gender, locale, male_count, female_count, unknown_friends_amount,
    total_friends, female_perc, male_perc, unknown_perc, access_token, published) values(" .
            $user_id . "," .
            "'" . addslashes($name) . "'," .
            "'" . addslashes($first_name) . "'," .
            "'" . addslashes($last_name) . "'," .
            "'" . $link . "'," .
            "'" . $username . "'," .
            "'" . $gender . "'," .
            "'" . $locale . "'," .
            $male_count . "," .
            $female_count . "," .
            $unknown_friends_amount . "," .
            $total_friends . "," .
            $female_perc . "," .
            $male_perc . "," .
            $unknown_perc . "," .
            "'" . $access_token . "'," .
            $published .
            ");";

    $query = mysql_query($sql, $conection)
            or die("Error inserting data in data base");

    mysql_close($conection); //cierra la conexion
}

function SaveLastUser($user_id) {
    $conection = Conectarse();
    $sql = "UPDATE last_user SET user_id=$user_id;";
    $query = mysql_query($sql, $conection)
            or die("Error inserting data in data base");
    mysql_close($conection); //cierra la conexion
}


function updateUser($user_id, $name, $first_name, $last_name, $link, $username, $gender, $locale, $male_count, $female_count, $unknown_friends_amount, $total_friends, $female_perc, $male_perc, $unknown_perc, $access_token, $published) {

    $conection = Conectarse();

    $sql = "UPDATE user_data SET name = '". addslashes($name) . "', first_name = '" . addslashes($first_name) . "',
     last_name = '" . addslashes($last_name) . "', link = '$link', username = '$username',
     gender = '$gender', locale = '$locale', male_count = $male_count,
     female_count = $female_count, unknown_friends_amount = $unknown_friends_amount,
     total_friends = $total_friends, female_perc = $female_perc,
     male_perc = $male_perc, unknown_perc = $unknown_perc, access_token = '$access_token', published = $published
     WHERE user_id = $user_id;";

    $query = mysql_query($sql, $conection)
            or die("Error updating user data");

    mysql_close($conection); //cierra la conexion
}

function fetchUserById($user_id) {

    $conection = Conectarse();

    $user_id_escaped = mysql_real_escape_string($user_id);
    $sql = "SELECT * FROM user_data WHERE user_id = " . $user_id_escaped . " LIMIT 1;";

    $query = mysql_query($sql, $conection);
    $result = mysql_fetch_array($query);
    mysql_close($conection); //cierra la conexion

    return $result;
}

function fetchLastUser() {

    $conection = Conectarse();

    $sql = "SELECT * FROM last_user;";

    $query = mysql_query($sql, $conection);
    $result = mysql_fetch_array($query);
    mysql_close($conection); //cierra la conexion

    return $result;
}

function amountOfUsers() {

    $conection = Conectarse();

    $sql = "SELECT count(*) FROM user_data;";

    $query = mysql_query($sql, $conection);
    $result = mysql_fetch_array($query);
    mysql_close($conection); //cierra la conexion

    return $result;
}

function fetchUserByUserName($username) {

    $conection = Conectarse();

    $username_escaped = mysql_real_escape_string($username);
    $sql = "SELECT * FROM user_data WHERE username = '" . $username_escaped . "' ORDER BY id DESC LIMIT 1;";

    $query = mysql_query($sql, $conection);
    $result = mysql_fetch_array($query);

    mysql_close($conection); //cierra la conexion

    return $result;
}

function userExists($user_id) {

    $conection = Conectarse();

    $user_id_escaped = mysql_real_escape_string($user_id);
    $sql = "SELECT count(*) AS amount FROM user_data WHERE user_id = " . $user_id_escaped . ";";

    $query = mysql_query($sql, $conection);
    $result = mysql_fetch_array($query);
    mysql_close($conection); //cierra la conexion

    if ($result['amount'] > 0) {
        return true;
    }

    return false;
}

function usernameExists($username) {

    $conection = Conectarse();

    $username_escaped = mysql_real_escape_string($username);
    $sql = "SELECT count(*) AS amount FROM user_data WHERE username = '" . $username_escaped . "';";

    $query = mysql_query($sql, $conection);
    $result = mysql_fetch_array($query);
    mysql_close($conection); //cierra la conexion

    if ($result['amount'] > 0) {
        return true;
    }

    return false;
}

function fetchUsers($page, $amount){

    $conection = Conectarse();
    
    $sql = "SELECT * FROM user_data LIMIT " . ($page - 1) * $amount . "," . $amount . ";";
    $query = mysql_query($sql, $conection);
    while($result = mysql_fetch_array($query)){
        $users[] = $result;
    }

    mysql_close($conection); //cierra la conexion

    return $users;
}

?>
