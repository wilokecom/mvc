<?php declare(strict_types=1);

use \MVC\Support\Route;
use \MVC\Support\Session;

incViewFile("header");
?>
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
        <?php echo Route::get("post/handle-add"); ?>"
              enctype="multipart/form-data">
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
            <!--Submit-->
            <div class="field" style="margin-top: 20px">
                <button class="ui red basic button" type="submit">Submit</button>
            </div>

        </form>
    </div>
<?php
incViewFile("footer");

