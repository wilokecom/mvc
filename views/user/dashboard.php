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
    $aPostInfo = $aData[1];
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
            <th>Post ID</th>
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
        $id=0;//Chỉ số mảng bài viết
        foreach ($aPostInfo as $aPostInfo) {
            echo "<tr>";
            echo "<td>" . $aPostInfo["post_author"] . "</td>";
            echo "<td>" . $aPostInfo["ID"] . "</td>";
            echo "<td>" . $aUserInfo["username"] . "</td>";
            echo "<td>" . $aPostInfo["post_title"] . "</td>";
            echo "<td class=\"read-more\">" . $aPostInfo["post_content"]."</td>";
            echo "<td>" . $aPostInfo["post_status"] . "</td>";
            echo "<td>" . $aPostInfo["post_type"] . "</td>";
            ?>
            <td>
                <a href="<?php echo Route::get("post/edit/".$aPostInfo["ID"]."/") ;?>">
                    <img width="16"
                         src="<?php echo MVC_SOURCES_URL . "icon/icon_edit.png"; ?>">
                </a>
            </td>
            <td>
                <a class="deleteItem" href="javascript:deleteItem(<?php echo $aPostInfo["ID"]?>)">
                    <img width="16" src="<?php echo MVC_SOURCES_URL . "icon/icon_delete.png"; ?>">
                </a>
            </td>
            <?php
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <div >
        <p id="delete-result" style="text-align:center;color: red;font-size: medium "></p>
    </div>
    <!-- Hộp thoại cảnh báo-->
    <div id="dialog-confirm" title="Xác nhận!!!!!!!" style= "display:none;">
        <p >
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            <br>Bạn có chắc muốn xóa bài viết này?
        </p>
    </div>
</div>
<?php
//Include file views/footer->Không có gì
incViewFile("footer");
?>
