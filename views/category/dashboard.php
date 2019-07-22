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
        $aTermsInfo=$aData[0];
    }
    ?>
    <!--Content-->
    <table class="ui celled table" style="display:<?php echo($aTermsInfo==null)?"none":""?>">
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
            echo "<td >" .$aTermsInfo["description"] . "</td>";
            echo "<td>" . $aTermsInfo["slug"]. "</td>";
            echo "<td>" . $aTermsInfo["count_taxonomy"] . "</td>";
            ?>
            <td>
                <a href="<?php echo Route::get("category/edit?category-name=" .$aTermsInfo["term_name"]) ;?>">
                    <img width="16"  src="<?php echo MVC_SOURCES_URL . "icon/icon_edit.png"; ?>">
                </a>
            </td>
            <td>
                <a class="deleteCategory" href="<?php echo $aTermsInfo["term_id"]?>">
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
    <!--Add new Category-->
    <div style="text-align: right;">
        <a href="<?php echo Route::get("category/add") ;?>"> Add New Category</a>
    </div>
    <!--Pagination Href-->
    <div class="pagination" >
        <?php echo Pagination::display(); ?>
    </div>
    <!-- Delete Alert Dialog-->
    <div id="dialog-confirm" title="Xác nhận!!!!!!!" style= "display:none;">
        <p >
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            <br>Bạn có chắc muốn xóa Category này?
        </p>
    </div>
</div>
<?php
//Include file views/footer
incViewFile("footer");
?>
