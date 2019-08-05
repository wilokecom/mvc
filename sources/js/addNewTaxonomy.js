//Function add NewCategory
function addNewTaxonomy(taxonomy)
{
    let taxonomy_name = $("#" + taxonomy + "-name").val();
    let input = "";
    let url = HomeURL + taxonomy + "/handle-quickadd";
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: {[taxonomy + "_name"]: taxonomy_name},
        success: function (data) {
            if (data == taxonomy_name) {
                $("#" + taxonomy + "_warning").html("Add" + " " + taxonomy + " " + "success").attr("style", "color:green");
                input = "<input type=\"checkbox\" value=\"" + data + "\">" + data + "<br>";
                $("." + taxonomy + "_checkbox").append(input);
            } else {
                $("#" + taxonomy + "_warning").html(data).attr("style", "color:red");
            }
            //Clear input after add sucess
            window[taxonomy + "_name"] = $("#" + taxonomy + "-name").val("");
        }
    })
}

//When press add new category
$("#add_category").on("click", "", "", function (event) {
    addNewTaxonomy("category");
})
//When press Enter
$("#category-name").on('keypress', function (event) {
    if (event.which == 13) {
        addNewTaxonomy("category");
    }
});
//When press add new tag
$("#add_tag").on("click", "", "", function (event) {
    addNewTaxonomy("tag");
})
//When press Enter
$("#tag-name").on('keypress', function (event) {
    if (event.which == 13) {
        addNewTaxonomy("tag");
    }
});

//Enable and disable Add new category button
let category = $('#add_category');
$('#category-name').on('input', function (event) {
    if ($(this).val().length) {
        category.prop('disabled', false);
    } else {
        category.prop('disabled', true);
    }
});

//Enable and disable Add new tag button
let tag = $('#add_tag');
$('#tag-name').on('input', function (event) {
    if ($(this).val().length) {
        category.prop('disabled', false);
    } else {
        category.prop('disabled', true);
    }
});





