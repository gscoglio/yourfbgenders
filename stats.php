<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'db.php';
include_once 'config.php';

$username = $_GET['username'];
$user_id = $_GET['user_id'];
$param = $_GET['param'];

$params_array = explode("/", $param);
if (sizeof($params_array) == 2 && is_numeric($params_array[1])) {
    $user_id = $params_array[1];
} elseif (sizeof($params_array) == 1) {
    $username = $params_array[0];
} else {
    include_once 'index.php';
    die();
}

if ($username != null && usernameExists($username)) {
    $user = fetchUserByUserName($username);
} elseif ($user_id != null && userExists($user_id)) {
    $user = fetchUserById($user_id);
} else {
    include_once 'index.php';
    die();
}

$name = stripcslashes($user['name']);
$male_count = $user['male_count'];
$female_count = $user['female_count'];
$unknown_friends_amount = $user['unknown_friends_amount'];
$total_friends = $user['total_friends'];
$female_perc = $user['female_perc'];
$male_perc = $user['male_perc'];
$unknown_perc = $user['unknown_perc'];
?>
<head>
    <title><?php echo($name); ?> friends genders</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="robots" content="index">
    <meta name="robots" content="follow">
    <meta name="robots" content="all" />
    <meta name="description" content="<?php echo($name); ?> friends genders" />
    <meta name="keywords" content="<?php echo($name); ?>, facebook, friends, genders, female, male, gender" />
    <meta name="Language" content="en-us" />
    <link href="<?php echo($my_url); ?>css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-25240289-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <!--Load the AJAX API-->
    <?php include_once 'graph.php'; ?>
</head>
<body style="text-align:center">
    <div id="stats_title">
        <div id="stats_pic">
            <?php
            if ($username != null) {
                $id_for_url = $username;
            } elseif ($user_id != null) {
                $id_for_url = $user_id;
            } else {
                $id_for_url = "";
            }
            ?>
            <img id="stats_img" alt="<?php echo($name) ?>" src="https://graph.facebook.com/<?php echo($id_for_url);?>/picture"/>
        </div>
        <div id="stats_text">
            <h1><?php echo($name) ?>'s friends genders:</h1>
        </div>
    </div>
    <div id="contenedor">
        <?php include_once 'table.php'; ?>
            <div id="chart">
                <!--Div that will hold the pie chart-->
                <div id="chart_div"></div>
            </div>
        </div>
        <div id="find_your_friends_container">
        <?php
            include 'config.php';
            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
            $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
                    . $app_id . "&redirect_uri=" . urlencode($my_url)
                    . "&scope=friends_about_me,publish_stream"
                    . "&state=" . $_SESSION['state'];
        ?>

            <div id="find_your_friends_bt" ><a href=<?php echo($dialog_url); ?>><img id="find_your_friends_bt_img" class="center" src="<?php echo($my_url); ?>images/your_friend_genders_button.png" alt="Find out four friends genders!"></a></div>
        </div>
    </body>
<?php
            include_once 'footer.php';
?>
	