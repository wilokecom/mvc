<?php declare(strict_types=1);
use \MVC\Support\Route;
use \MVC\Support\Session;

incViewFile("header");
?>
    <!--Container-->
    <div id="container">
        <!--Top-menu-->
        <?php
        incViewFile("top-menu");
        if (isset($aData)) {
            $aCategoryInfo = $aData[0];
        }
        ?>
        <!--Error-->
        <?php
        $hasError = Session::has("category_error");
        if ($hasError) {
            $formClass = "ui form error";
        } else {
            $formClass = "ui form";
        }
        ?>
        <form class="<?php echo $formClass; ?>" method="POST" action="
            <?php echo Route::get("category/handle-edit?category-name=" . $aCategoryInfo["term_name"]); ?>"
              enctype="multipart/form-data">
            <!--Display Error-->
            <?php if ($hasError) : ?>
                <div class="ui error message">
                    <p><?php echo Session::get("category_error"); ?></p>
                </div>
            <?php endif; ?>
            <!--Name-->
            <div class="field">
                <label for="category-name">Name</label>
                <input id="category-name" type="text" name="category-name" placeholder="Category Name"
                       value="<?php echo $aCategoryInfo["term_name"]; ?>">
            </div>
            <!--Slug-->
            <div class="field">
                <label for="slug">Slug</label>
                <input id="slug" type="text" name="slug" placeholder="Slug"
                       value="<?php echo $aCategoryInfo["slug"]; ?>">
            </div>
            <!--Description-->
            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" rows="2" name="description" placeholder="Description"
                          value=""><?php echo $aCategoryInfo["description"]; ?></textarea>
            </div>
            <!--Submit-->
            <div class="field" style="margin-top: 20px">
                <button class="ui red basic button" type="submit">Add New Category</button>
            </div>
        </form>
    </div>
<?php
incViewFile("footer");


