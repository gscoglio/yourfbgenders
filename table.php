<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<div id="table">
    <!-- Table markup-->
    <table id="rounded-corner" summary="Friends' Genders">

        <!-- Table header -->

        <thead>
            <tr>
                <th scope="col" >Genders</th>
                <th scope="col" >Amount</th>
                <th scope="col" >Percentages</th>
            </tr>
        </thead>

        <!-- Table footer -->

        <tfoot>
            <tr>
                <td>Total amount of friends</td>
                <td colspan=2><?php echo($params['total_friends']); ?></td>
            </tr>
        </tfoot>

        <!-- Table body -->

        <tbody>
            <tr>
                <td>Female friends</td>
                <td><?php echo($params['female_count']); ?></td>
                <td><?php echo($params['female_perc'] . ' %'); ?></td>
            </tr>
            <tr>
                <td>Male friends</td>
                <td><?php echo($params['male_count']); ?></td>
                <td><?php echo($params['male_perc'] . ' %'); ?></td>
            </tr>
            <tr>
                <td>Unknown gender friends</td>
                <td colspan=2><?php echo($params['unknown_friends_amount']); ?></td>
<!--                <td><?php echo($params['unknown_perc'] . ' %'); ?></td>-->
            </tr>
        </tbody>

    </table>
</div>