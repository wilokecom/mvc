<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 01/08/2019
 * Time: 10:45 SA
 */
use \MVC\Support\Pagination;
use \MVC\Support\Route;

incViewFile("header");
?>

<div id="container">
    <?php
    incViewFile("top-menu");
    if (isset($aData)) {
        $aTermsInfo = $aData[0];
    }
    $aTermsInfo=array();
    ?>

<!--    style="display:--><?php //echo
//    ($aTermsInfo == null) ? "none" : "" ?><!--"-->
    <table class="ui celled table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Slug</th>
            <th>Count</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody id="content">
        <?php
        foreach ($aTermsInfo as $aTermsInfo) {
            echo "<tr>";
            echo "<td>" . $aTermsInfo["term_name"] . "</td>";
            echo "<td>" . $aTermsInfo["description"] . "</td>";
            echo "<td>" . $aTermsInfo["slug"] . "</td>";
            echo "<td>" . $aTermsInfo["count_taxonomy"] . "</td>"; ?>
            <td></td>
            <td></td>
            <?php
        }
        ?>
        </tbody>
    </table>

</div>
