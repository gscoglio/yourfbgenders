<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';

function printResults($params) {

    global $my_url;
?>
    <head>
        <title>Your Facebook Friend Genders</title>
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
    <div style="text-align: center">
        <h1>These are your results:</h1>
    </div>
    <div id="contenedor">
        <?php include_once 'table.php'; ?>
        <div id="chart">
            <!--Div that will hold the pie chart-->
            <div id="chart_div"></div>
        </div>
    </div>
<!--    <div id="post_wall_container">-->
        <div id="home_link" >
            <p>Your results have been published in your Facebook wall. Go back to <a href=<?php echo($my_url); ?>>home</a></p>
        </div>
<!--    </div>-->
</body>
<?php
        include_once 'footer.php';
    }

    ;
?>
