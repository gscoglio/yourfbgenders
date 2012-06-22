<?php
//session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';
include_once 'db.php';

function post_to_wall($user_id, $username, $first_name, $last_name, $male_count, $male_perc, $female_count, $female_perc, $access_token) {

    //$quantity = intval($_SESSION['veces']);
    //if($quantity > 0) return;
    
    //$_SESSION['veces']++;

    $last_user = fetchLastUser();

    if($last_user['user_id'] == $user_id)return;
    //var_dump($last_user['user_id']);
    //var_dump($user_id);
    //die();
    SaveLastUser($user_id);

    global $app_id;
    global $my_url;

    if ($username != null) {
        $url_end = $username;
    } else {
        $url_end = $first_name . "-" . $last_name . "/" . $user_id;
    }

    $link = $my_url . $url_end;
    $picture = $my_url . "images/for_wall.png";
    $caption = "Find out your Facebook friends genders";
    $description = "Want to know the genders of your Facebook friends? Your Fb Genders gives you that porcentage!";
    $message = "These are my friends in Facebook: I have " . $male_count .
            " male friends (" . $male_perc . "%) and " . $female_count .
            " female friends (" . $female_perc . "%)";
    $redirect_uri = $my_url . $url_end;
    $name = "See my results and calculate your amounts here!";

    $url = "https://graph.facebook.com/$user_id/feed";

    $postData = array("access_token" => $access_token, "app_id" => $app_id,
        "link" => $link, "picture" => $picture, "caption" => $caption,
        "description" => $description, "name" => $name,
        "message" => $message);

    /* Convierte el array en el formato adecuado para cURL */
    $elements = array();
//    foreach ($postData as $name => $value) {
//        $elements[] = "{$name}=" . urlencode($value);
//        //$elements[] = "{$name}=" . $value;
//    }
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
			