<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';
include_once 'db.php';

function print_home($dialog_url) {

    global $my_url;
    $db = new DataBase();
?>
    <head>
        <title>Facebook Friend Genders</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index">
        <meta name="robots" content="follow">
        <meta name="robots" content="all" />
        <meta name="description" content="Find out your facebook friends genders. Using this application you will know how many of your facebook friends are female and how many are male. See results in graphs and post them in your facebook wall." />
        <meta name="keywords" content="facebook, friends, genders, female, male, gender" />
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
    </head>
    <body>
<div style="text-align:center">
        <img class="center" src="<?php echo($my_url); ?>images/yourfbgenders.png" alt="Your Facebook Genders">
        <div id="find_friends_button" >
            <a href=<?php echo($dialog_url) ?>><img id="button_image" class="center" src="<?php echo($my_url); ?>images/button.png" alt="Find out your facebook genders!"></a>
        </div>
        <div id="home_message">
            <p>Results will be published in your wall</p>
            <?php $users_amount = $db->amountOfUsers();?>
            <p><?php echo($users_amount[0]);?> users have already tried this app!</p>
        </div>
</div>
    <?php
    include_once 'footer.php';
    ?>
</body>
<?php
}

;
?>
