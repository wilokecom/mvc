//When press add new tag
$("#add_tag").on("click", "", "", function () {
    "use strict";
    let tag_name = $("#tag-name").val();
    $.ajax({
        url: "http://localhost/mvc/tag/handle-quickadd",
        type: "POST",
        dataType: "html",
        data: {tag_name: tag_name},
        success: function (data) {
            if (data == tag_name) {
                $("#tag_warning").html("Add Tag Success").attr("style", "color:green");
                let input = "<input type=\"checkbox\" value=\"" + data + "\">" + data + "<br>";
                $(".tag_checkbox").append(input);
            } else {
                $("#tag_warning").html(data).attr("style", "color:red");
            }
        }
    })
})
//Enable and disable Add new tag button
let tag = $('#add_tag');
$('#tag-name').on('input', function (event) {
    if ($(this).val().length) {
        tag.prop('disabled', false);
    } else {
        tag.prop('disabled', true);
    }
});




