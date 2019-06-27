<?php

use \MVC\Support\Route;
use \MVC\Support\Session;

incViewFile("header");
?>
    <div id="container">
        <!--Top-menu-->
        <?php
        incViewFile("top-menu");
        $aPostInfo = $aData[0];
        $id=$aData[1];
        ?>
        <!--Error-->
        <?php
        //Lấy lỗi Session
        $hasError = Session::has("post_error");
        if ($hasError) {
            $formClass = "ui form error";
        } else {
            $formClass = "ui form";
        }
        ?>
        <form class="<?php echo $formClass; ?>" method="POST"
              action="<?php echo Route::get("post/handle-edit/".$id."/");?>" enctype="multipart/form-data">
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
                        <input id="publish" type="radio" name="post-status" value="publish" checked="checked"
                        <?php
                        echo ($aPostInfo["post_status"]=="publish") ? "checked=\"checked\"" : "" ;
                        ?>">
                        <label for="publish">Publish</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input id="none-publish" type="radio" name="post-status" value="none-publish"
                        <?php
                        echo ($aPostInfo["post_status"]=="none-publish") ? "checked=\"checked\"" : "" ;
                        ?>">
                        <label for="none-publish">None-Publish</label>
                    </div>
                </div>
            </div>
            <!--Type-->
            <div class="grouped fields">
                <label>Type</label>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input id="post" type="radio" name="post-type" value="post"
                        <?php
                        echo ($aPostInfo["post_type"]=="post") ? "checked=\"checked\"" : "" ;
                        ?>">
                        <label for="post">Post</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input id="page" type="radio" name="post-type" value="page"
                        <?php
                        echo ($aPostInfo["post_type"]=="page") ? "checked=\"checked\"" : "" ;
                        ?>">
                        <label for="page">Page</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input id="attachment" type="radio" name="post-type" value="attachment"
                        <?php
                        echo ($aPostInfo["post_type"]=="attachment") ? "checked=\"checked\"" : "" ;
                        ?>">
                        <label for="attachment">Attachment</label>
                    </div>
                </div>
            </div>
            <!--Title-->
            <div class="field">
                <label for="post-title">title</label>
                <input id="post-title" type="text" name="post-title" placeholder="Title" value="<?php echo $aPostInfo["post_title"];?>">
            </div>
            <!--Content-->
            <div class="field">
                <label for="post-content">Content</label>
                <textarea id="post-content" rows="2" name="post-content" placeholder="Content" value=""><?php echo $aPostInfo["post_content"];?></textarea>
            </div>
            <!--Submit-->
            <div class="field" style="margin-top: 20px">
                <button class="ui red basic button" type="submit">Change</button>
            </div>

        </form>
    </div>
<?php
incViewFile("footer");

