<?php
use \MVC\Support\Route;
use \MVC\Support\Pagination;

//Go to function incViewFile -file index.php
//Add CSS-JS for header,body,footer
incViewFile("header"); //Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php
    incViewFile("top-menu");
    if (isset($aData)) {
        $aUserInfo=$aData[0];
        $aPostInfo=$aData[1];
    }
    ?>
    <!--Content-->
    <div class="ui success message">
        <div class="header">Hello <span style="color:red;"><?php echo $aUserInfo["username"]; ?></span>!
            <!--Hello username-->
            <p>Đây là trang Dashboard.</p>
        </div>
    </div>
    <table class="ui celled table" style="display:<?php echo ($aPostInfo == null) ? "none" : "" ?>">
        <thead>
        <tr>
            <th>User Name</th>
            <th>User ID</th>
            <th>Post ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Status</th>
            <th>Type</th>
            <th>Comment</th>
            <th>Categories</th>
            <th>Tags</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody id="content">
        <?php
        //foreach ($aPostInfo as $aPostInfo)
        foreach ($aPostInfo as $aPostInfo) {
            echo "<tr>";
            echo "<td>" . $aUserInfo["username"] . "</td>";
            echo "<td >" . $aPostInfo["post_author"] . "</td>";
            echo "<td>" . $aPostInfo["ID"] . "</td>";
            echo "<td>" . $aPostInfo["post_title"] . "</td>";
            echo "<td class=\"read-more\">" . $aPostInfo["post_content"] . "</td>";
            echo "<td>" . $aPostInfo["post_status"] . "</td>";
            echo "<td>" . $aPostInfo["post_type"] . "</td>";
            echo "<td>" . "</td>";
            echo "<td>" . $aPostInfo["category"] . "</td>";
            echo "<td>" . $aPostInfo["tag"] . "</td>";
            ?>
            <td>
                <a href="<?php echo Route::get("post/edit?post-id=" . $aPostInfo["ID"]); ?>">
                    <img width="16"  src="<?php echo MVC_SOURCES_URL . "icon/icon_edit.png"; ?>">
                </a>
            </td>
            <td>
                <a class="deletePost" href="<?php echo $aPostInfo["ID"] ?>">
                    <img width="16" src="<?php echo MVC_SOURCES_URL . "icon/icon_delete.png"; ?>">
                </a>
            </td>
            <?php
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <!--Delete Result-->
    <div >
        <p id="delete-result" style="text-align:center;color: red;font-size: medium "></p>
    </div>
    <!--Pagination Href-->
    <div class="pagination" >
        <?php echo Pagination::display(); ?>
    </div>
    <!-- Delete Alert Dialog-->
    <div id="dialog-confirm" title="Xác nhận!!!!!!!" style= "display:none;">
        <p >
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            <br>Bạn có chắc muốn xóa bài viết này?
        </p>
    </div>
</div>
<?php
//Include file views/footer
incViewFile("footer");
?>
