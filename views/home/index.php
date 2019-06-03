<?php incViewFile('header'); ?>
<div id="container">
    <?php incViewFile('top-menu'); ?>
    <div class="ui message green">
        <div class="sixteen wide column">Hello! Thank for visitit MVC</div>
    </div>

    <form class="ui form">
        <div class="field">
            <label>First Name</label>
            <input type="text" name="first-name" placeholder="First Name">
        </div>
        <div class="field">
            <label>Last Name</label>
            <input type="text" name="last-name" placeholder="Last Name">
        </div>
        <div class="field">
            <div class="ui checkbox">
            <input type="checkbox" tabindex="0" class="hidden">
            <label>I agree to the Terms and Conditions</label>
            </div>
        </div>
        <button class="ui button" type="submit">Submit</button>
    </form>

</div>
<?php incViewFile('footer'); ?>