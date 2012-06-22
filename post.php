<?php
//session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';
include_once 'db.php';

function postToWall($params) {

    $db = new DataBase();

    $last_user = $db->fetchLastUser();
    
    if ($last_user['user_id'] == $params['user_id']) return;

    $db->saveLastUser($params['user_id']);

    global $app_id;
    global $my_url;

    if ($params['username'] != null) {
        $url_end = $params['username'];
    } else {
        $url_end = 
            $params['first_name'] . "-" .
            $params['last_name'] . "/" .
            $params['user_id']
        ;
    }

    $link = $my_url . $url_end;
    $picture = $my_url . "images/for_wall.png";
    $caption = "Find out your Facebook friends genders";
    $description = "Want to know the genders of your Facebook friends? Your Fb Genders gives you that porcentage!";
    $message = "These are my friends in Facebook: I have " .
        $params['male_count'] . " male friends (" .
        $params['male_perc'] . "%) and " .
        $params['female_count'] . " female friends (" .
        $params['female_perc'] . "%)"
    ;
    $redirect_uri = $my_url . $url_end;
    $name = "See my results and calculate your amounts here!";

    $url = "https://graph.facebook.com/{$params['user_id']}/feed";

    $postData = array(
        "access_token" => $params['access_token'],
        "app_id"       => $app_id,
        "link"         => $link,
        "picture"      => $picture,
        "caption"      => $caption,
        "description"  => $description,
        "name"         => $name,
        "message"      => $message,
    );

    /* Convierte el array en el formato adecuado para cURL */
    $elements = array();
    $handler = curl_init();
    curl_setopt($handler, CURLOPT_URL, $url);
    curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($handler, CURLOPT_POST, true);
    curl_setopt($handler, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handler);
    curl_close($handler);
}

?>		