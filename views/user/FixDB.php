<?php
use MVC\Support\Session;

/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 13/08/2019
 * Time: 5:09 CH
 */

incViewFile('header');

?>
<div id="container">
    <!--Top-menu-->
    <?php incViewFile("top-menu"); ?>
    <!--Content-->
    <?php
    if (Session::has("login_error")) :?>
        <div class="ui error message">
            <p><?php echo Session::get("login_error"); ?></p>
        </div>
    <?php endif;
    ?>
    <form class="ui form" method="POST"
          action="<?php echo \MVC\Support\Route::get(
              "user/handlefixDB"
          ); ?>">
        <div class="field">
            <label for="Colums">Table Colums</label>
            <input id="Colums" type="text" name="Colums"
                   placeholder="Colums">
        </div>
        <div class="field">
            <label for="valueCol">Value Colums</label>
            <input id="valueCol" type="text" name="valueCol"
                   placeholder="Password">
        </div>
        <button class="ui button" type="submit">Submit</button>
    </form>
</div>
<?php
//Include file views/footer->Không có gì
incViewFile("footer");
?>
