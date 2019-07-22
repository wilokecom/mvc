<?php declare(strict_types=1);

use \MVC\Support\Route;
use \MVC\Support\Session;

incViewFile("header");
?>
<?php
$aCategoryName = isset($aData[0]) ? $aData[0] : null;
$aTagName      = isset($aData[1]) ? $aData[1] : null;
?>
    <!--Sidebar-->
    <div class="ui sidebar vertical left inverted menu" id="sidebar">
        <!--Category-->
        <button class="term">Categories</button>
        <div class="term_content">
            <!--category_checkbox-->
            <div class="category_checkbox">
                <?php
                echo "<p id=\"category_warning\"></p>";
                $category = "";
                for ($i = 0; $i < count($aCategoryName); $i++) {
                    $category .= "<input id=\"\" type=\"checkbox\"
                    name=\"category[]\" value=\"" . $aCategoryName[$i]["term_name"] . "\">" .
                                 $aCategoryName[$i]["term_name"] . "<br>";
                }
                echo $category;
                ?>
            </div>
            <!--Button Add new Catgory-->
            <button id="add_new_category">Add new Category</button>
            <!--Display form add new category-->
            <div class="add_new_category">
                <label for="category-name">CategoryName</label>
                <input id="category-name" type="text" name="category-name" placeholder="Category">
                <button class="ui button" id="add_category" disabled>Add new Category</button>
            </div>
        </div>
        <!--Tag-->
        <button class="term">Tags</button>
        <div class="term_content">
            <!--category_checkbox-->
            <div class="tag_checkbox">
                <?php
                echo "<p id=\"tag_warning\"></p>";
                $tag = "";
                for ($i = 0; $i < count($aTagName); $i++) {
                    $tag .= "<input id=\"" . $aTagName[$i]["term_name"] . "\" type=\"checkbox\"
                    name=\"tag[]\">" . $aTagName[$i]["term_name"] . "<br>";
                }
                echo $tag;
                ?>
            </div>
            <!--Button Add new Tag-->
            <button id="add_new_tag">Add new Tag</button>
            <!--Display form add new tag-->
            <div class="add_new_tag">
                <label for="tag-name">TagName</label>
                <input id="tag-name" type="text" name="tag-name" placeholder="Tag">
                <button class="ui button" id="add_tag" disabled>Add new Tag</button>
            </div>
        </div>
        <button class="term">
            Excerpt
        </button>
        <div class="term_content">
        </div>
        <button class="term">
            Discussion
        </button>
        <div class="term_content">
        </div>
    </div>
    <!--Menu icon-->
    <div class="ui basic icon top fixed menu">
        <a id="toggle" class="item">
            <i class="sidebar icon"></i>
            Menu
        </a>
    </div>
    <div class="pusher">
        <!--Container-->
        <div id="container">
            <!--Top-menu-->
            <?php
            incViewFile("top-menu");
            ?>
            <!--Error-->
            <?php
            $hasError = Session::has("post_error");
            if ($hasError) {
                $formClass = "ui form error";
            } else {
                $formClass = "ui form";
            }
            ?>
            <form class="<?php echo $formClass; ?>" method="POST" action="
            <?php echo Route::get("post/handle-add"); ?>" enctype="multipart/form-data">
                <!--Display Error-->
                <?php if ($hasError) : ?>
                    <div class="ui error message">
                        <p><?php echo Session::get("post_error"); ?></p>
                    </div>
                <?php endif; ?>
                <!--Information-->
                <h4 class="ui dividing header">Information</h4>
                <!--Status-->
                <div class="grouped fields">
                    <label>Status</label>
                    <div class="field">
                        <div class="ui slider checkbox">
                            <input id="publish" type="radio" name="post-status" value="publish" checked="checked">
                            <label for="publish">Publish</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui slider checkbox">
                            <input id="none-publish" type="radio" name="post-status" value="none-publish">
                            <label for="none-publish">None-Publish</label>
                        </div>
                    </div>
                </div>
                <!--Type-->
                <div class="grouped fields">
                    <label>Type</label>
                    <div class="field">
                        <div class="ui slider checkbox">
                            <input id="post" type="radio" name="post-type" value="post" checked="checked">
                            <label for="post">Post</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui slider checkbox">
                            <input id="page" type="radio" name="post-type" value="page">
                            <label for="page">Page</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui slider checkbox">
                            <input id="attachment" type="radio" name="post-type" value="attachment">
                            <label for="attachment">Attachment</label>
                        </div>
                    </div>
                </div>
                <!--Title-->
                <div class="field">
                    <label for="post-title">title</label>
                    <input id="post-title" type="text" name="post-title" placeholder="Title">
                </div>
                <!--Content-->
                <div class="field">
                    <label for="post-content">Content</label>
                    <textarea id="post-content" rows="2" name="post-content" placeholder="Content"></textarea>
                </div>
                <!--Image-->
                <div class="ui action input">
                    <input id="featured-image" type="file" placeholder="Featured Image" name="image-upload">
                    <label for="featured-image" class="ui button">Upload</label>
                </div>
                <!--Additional information-->
                <h4 class="ui dividing header">Additional Information</h4>
                <div class="field">
                    <label for="phone-number">Phone Number</label>
                    <input id="phone-number" type="text" name="phone-number">
                </div>
                <!--Category-->
                <div class="category_checkbox field">
                    <label>Categories</label>
                    <?php
                    $category = "<br>";
                    for ($i = 0; $i < count($aCategoryName); $i++) {
                        $category .= "<input id=\"\" type=\"checkbox\"
                    name=\"category[]\" value=\"" . $aCategoryName[$i]["term_name"] . "\">" .
                                     $aCategoryName[$i]["term_name"] . "<br>";
                    }
                    echo $category;
                    ?>
                </div>
                <!--Tag-->
                <div class="tag_checkbox field">
                    <label>Tags</label>
                    <?php
                    $tag = "<br>";
                    for ($i = 0; $i < count($aTagName); $i++) {
                        $tag .= "<input id=\"\" type=\"checkbox\"
                    name=\"tag[]\" value=\"" . $aTagName[$i]["term_name"] . "\">" .
                                $aTagName[$i]["term_name"] . "<br>";
                    }
                    echo $tag;
                    ?>
                </div>
                <!--Submit-->
                <div class="field" style="margin-top: 20px">
                    <button class="ui red basic button" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php
incViewFile("footer");

