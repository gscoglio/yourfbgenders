<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'home.php';
include_once 'results.php';
include_once 'config.php';
include_once 'db.php';
include_once 'post.php';

session_start();
$code = $_REQUEST["code"];

if (empty($code)) {
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
            . $app_id . "&redirect_uri=" . urlencode($my_url)
            . "&scope=friends_about_me,publish_stream,offline_access"
            . "&state=" . $_SESSION['state'];

    // Imprimo la home:
    print_home($dialog_url);
} else {
    //if ($_REQUEST['state'] == $_SESSION['state']) {
    $token_url = "https://graph.facebook.com/oauth/access_token?"
            . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
            . "&client_secret=" . $app_secret . "&code=" . $code;

    $response = @file_get_contents($token_url);
    $params = null;

    if($response == false || empty($response)){
       echo("There has been an error connecting to Facebook");
       die();
    }

    parse_str($response, $params);

    $my_data_url = "https://graph.facebook.com/me?access_token="
            . $params['access_token'];

    $my_data = json_decode(@file_get_contents($my_data_url));

    $user_id = $my_data->id;
    $name = $my_data->name;
    $first_name = $my_data->first_name;
    $last_name = $my_data->last_name;
    $link = $my_data->link;
    $username = $my_data->username;
    $my_gender = $my_data->gender;
    $locale = $my_data->locale;

    //http://www.arsys.info/programacion/bases-de-datos/php-acceso-a-bases-de-datos/
    //http://www.webestilo.com/php/php07b.phtml

    $user_friends_url = "https://graph.facebook.com/me/friends?fields=gender&access_token="
            . $params['access_token'];

    $user_friends = json_decode(file_get_contents($user_friends_url));
    $total_friends = sizeof($user_friends->data);

    $male_count = 0;
    $female_count = 0;

    foreach ($user_friends->data as $friend) {
        $gender = $friend->gender;

        switch ($gender) {
            case "male":
                $male_count++;
                break;
            case "female":
                $female_count++;
                break;
        }
    }

    $unknown_friends_amount = $total_friends - $female_count - $male_count;
    $total_friends_without_unknown = $female_count + $male_count;
    $female_perc = number_format(($female_count / $total_friends_without_unknown) * 100, 2);
    $male_perc = number_format(($male_count / $total_friends_without_unknown) * 100, 2);
    $unknown_perc = number_format(($unknown_friends_amount / $total_friends) * 100, 2);

    if (userExists($user_id)) {
        updateUser($user_id, $name, $first_name, $last_name, $link,
                $username, $my_gender, $locale, $male_count, $female_count,
                $unknown_friends_amount, $total_friends, $female_perc,
                $male_perc, $unknown_perc, $params['access_token'], 0);
    } else {
        InsertNewUser($user_id, $name, $first_name, $last_name, $link,
                $username, $my_gender, $locale, $male_count, $female_count,
                $unknown_friends_amount, $total_friends, $female_perc,
                $male_perc, $unknown_perc, $params['access_token'], 0);
    }

    post_to_wall($user_id, $username, $first_name, $last_name, $male_count,
            $male_perc, $female_count, $female_perc, $params['access_token']);

    print_results($user_id, $first_name, $last_name, $username, $male_count,
            $female_count, $unknown_friends_amount, $total_friends,
            $female_perc, $male_perc, $unknown_perc);
//    } else {
//        echo("The state does not match. You may be a victim of CSRF.");
//    }
}
?>
