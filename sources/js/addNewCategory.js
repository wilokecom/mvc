//When press add new category
$("#add_category").on("click", "", "", function () {
    "use strict";
    let category_name = $("#category-name").val();
    let input="";
    $.ajax({
        url: "http://localhost/mvc/category/handle-quickadd",
        type: "POST",
        dataType: "html",
        data: {category_name: category_name},
        success: function (data) {
            if (data == category_name) {
                $("#category_warning").html("Add Category Success").attr("style", "color:green");
                input = "<input type=\"checkbox\" value=\"" + data + "\">" + data + "<br>";
                $(".category_checkbox").append(input);
            } else {
                $("#category_warning").html(data).attr("style", "color:red");
            }
        }
    })
})
//Enable and disable Add new tag button
let category = $('#add_category');
$('#category-name').on('input', function (event) {
    if ($(this).val().length) {
        category.prop('disabled', false);
    } else {
        category.prop('disabled', true);
    }
});




