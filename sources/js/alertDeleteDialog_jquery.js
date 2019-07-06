$("#container").on("click", ".deleteItem","", function (event) {
    "use strict";
    let post_id = $(this).attr("href");
    let $self = $(this);
    event.preventDefault();
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 150,
        width: 400,
        modal: true,
        buttons: {
            "Yes": function () {
                $.ajax({
                    url: "http://localhost/mvc/post/delete",
                    type: "POST",
                    dataType: "html",
                    data: {post_id: post_id},
                    success: function (data) {
                        $("#delete-result").html(data);
                        if (data === "Delete Success") {
                            $self.parent().parent().remove();
                        }
                    }
                })
                //Close dialog
                $(this).dialog("close");
            },
            Cancel: function () {
                //Close dialog
                $(this).dialog("close");
            }
        }
    });
})


