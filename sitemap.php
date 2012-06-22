<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'db.php';

$page_size = 25;
$page = $_GET['page'];

$db = new DataBase();

if ($page == null || !is_numeric($page)) {
    $page = 1;
}

$users = $db->fetchUsers($page, $page_size);
$db = new DataBase();

?>
<head>
        <title>Sitemap - Your Facebook Friend Genders</title>
</head>
<body>
<div id="table">
    <!-- Table markup-->
    <table summary="Sitemap">

        <!-- Table header -->

        <thead>
            <tr>
                <th scope="col" >User ID</th>
                <th scope="col" >Name</th>
                <th scope="col" >Username</th>
                <th scope="col" >Total friends</th>
            </tr>
        </thead>

<?php
foreach ($users as $user) {
    $user_id = $user['user_id'];
    $name = $user['name'];
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $username = $user['username'];
    $total_friends = $user['total_friends'];

    if($username == NULL){
        $link = "http://www.yourfbgenders.com/$first_name-$last_name/$user_id";
    }  else {
        $link = "http://www.yourfbgenders.com/$username";
    }

?>

        <tr>
            <td><?php echo($user_id); ?></td>
            <td><?php echo('<a href="'.$link.'">'.$name.'</a>'); ?></td>
            <td><?php echo($username); ?></td>            
            <td><?php echo($total_friends); ?></td>
        </tr>

<?php
    }
?>

        </tbody>

    </table>
</div>
<div style="width: 400px">
<?php
if($page > 1){
    ?>
<div style="float:left">
    <p><?php echo('<a href="http://www.yourfbgenders.com/sitemap.php?page='.($page-1).'">PAGINA '.($page-1).'</a>');?> </p>
</div>
<?php
}
?>

<?php
$amount_of_users = $db->amountOfUsers();
if($page * $page_size < $amount_of_users[0]){
    ?>
<div style="float:right">
    <p><?php echo('<a href="http://www.yourfbgenders.com/sitemap.php?page='.($page+1).'">PAGINA '.($page+1).'</a>');?></p>
</div>
<?php
}
?>
</div>
</body>