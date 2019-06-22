<?php
use \MVC\Support\Route;

//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header,body,footer
incViewFile("header"); //Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php
    incViewFile("top-menu");
    $aUserInfo = $aData[0];
    $aPost     = $aData[1];
    ?>
    <!--Content-->
    <div class="ui success message">
        <div class="header">Hello <span
                    style="color:red;"><?php echo $aUserInfo["username"]; ?></span>!
            <!--Hello username-->
            <p>Đây là trang Dashboard.</p>
        </div>
    </div>
    <table class="ui celled table">
        <thead>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>Title</th>
            <th>Content</th>
            <th>Status</th>
            <th>Type</th>
            <th>Edit</th>
            <th>Delete</th>

        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($aPost as $aPost) {
            echo "<tr>";
            echo "<td>" . $aPost["post_author"] . "</td>";
            echo "<td>" . $aUserInfo["username"] . "</td>";
            echo "<td>" . $aPost["post_title"] . "</td>";
            echo "<td class=\"read-more\">" . $aPost["post_content"]."</td>";
            echo "<td>" . $aPost["post_status"] . "</td>";
            echo "<td>" . $aPost["post_type"] . "</td>";
            ?>
            <td>
                <a href="<?php echo Route::get("post/edit/");?>">
                    <img width="16"
                         src="<?php echo MVC_ASSETS_URL . "icon/icon_edit.png"; ?>">
                </a>
            </td>
            <td>
                <a href="https://semantic-ui.com/collections/table.html#table">
                    <img width="16" src="<?php echo MVC_ASSETS_URL . "icon/icon_delete.png"; ?>">
                </a>
            </td>
            <?php
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<?php
//Include file views/footer->Không có gì
incViewFile("footer");
?>
