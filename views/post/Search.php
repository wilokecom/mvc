<?php
use \MVC\Support\Route;
use \MVC\Support\Pagination;
use MVC\Support\Session;

incViewFile("header"); //Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php
    incViewFile("top-menu");
    if (isset($aData)) {
        $aUserInfo = $aData[0];
    }
    ?>
    <div class="ui success message">
        <div class="header">Search
        </div>
        <?php
        $hasError = Session::has("search_error");
        if ($hasError) {
            $formClass = "ui form error";
            echo "keyword does not exist";
        } else {
            $formClass = "ui form";
        }
        ?>
    </div>
    <table class="ui celled table" style="display: <?php echo ($aUserInfo
                                                               == false)
        ? "none" : ""; ?>">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Post ID</th>
            <!--            <th>User Name</th>-->
            <th>Tittle</th>
            <th>Content</th>
            <th>Status</th>
            <th>Type</th>
            <th>Tags</th>
            <th>Categories</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody id="content">
        <?php
        $id = 0;//Chỉ số mảng bài viết
        foreach ($aUserInfo as $aUserInfo) {
            echo "<tr>";
            echo "<td>" . $aUserInfo["post_author"] . "</td>";
            echo "<td>" . $aUserInfo["ID"] . "</td>";
            //            echo "<td>" . $aUserInfo["username"] . "</td>";
            echo "<td>" . $aUserInfo["post_tittle"] . "</td>";
            echo "<td class='read-more'>" . $aUserInfo["post_content"]
                 . "</td>";
            echo "<td>" . $aUserInfo["post_status"] . "</td>";
            echo "<td>" . $aUserInfo["post_type"] . "</td>";
            echo "<td></td>";
            echo "<td></td>";
            ?>
            <td>
                <a href="<?php echo Route::get(
                    "post/edit/" . $aUserInfo["ID"] . "/"
                ); ?>">
                    <img width="16"
                         src="<?php echo MVC_SOURCES_URL
                                         . "icon/icon_edit.png"; ?>">
                </a>
            </td>
            <td>
                <a class="deleteItem"
                   href="<?php echo $aUserInfo["ID"]; ?>">
                    <img width="16" src="<?php echo MVC_SOURCES_URL
                                                    . "icon/icon_delete.png"; ?>">
                </a>
            </td>
            <?php
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <div>
        <p id="delete-result" style="text-align:center;color:red ;font-size:
        medium ;"></p>
    </div>

    <!--Pagination Href-->
    <div class="pagination">
        <?php echo Pagination::display(); ?>
    </div>

    <!-- Delete alert Dialog-->
    <div id="dialog-confirm" title="Xác nhận!!!!!!!" style="display:none;">
        <p>
            <span class="ui-icon ui-icon-alert"
                  style="float:left; margin:12px 12px 20px 0;"></span>
            <br>Bạn có chắc muốn xóa bài viết này?
        </p>
    </div>

</div>
<?php
//Include file views/footer->Không có gì
incViewFile("footer");
?>
