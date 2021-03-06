//User/Dashboard
$("#container").on("click", ".deletePost","", function (event) {
    "use strict";
    let post_id = $(this).attr("href");
    let $self = $(this);
    let url=HomeURL+"post/delete"
    event.preventDefault();
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 150,
        width: 400,
        modal: true,
        buttons: {
            "Yes": function () {
                $.ajax({
                    url: url,
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
//Category/dashboard
$("#container").on("click", ".deleteCategory","", function (event) {
    "use strict";
    let term_id = $(this).attr("href");
    let $self = $(this);
    let url=HomeURL+"category/delete";
    event.preventDefault();
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 150,
        width: 400,
        modal: true,
        buttons: {
            "Yes": function () {
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "html",
                    data: {term_id: term_id},
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
//Tag/dashboard
$("#container").on("click", ".deleteTag","", function (event) {
    "use strict";
    let term_id = $(this).attr("href");
    let $self = $(this);
    let url=HomeURL+"tag/delete";
    event.preventDefault();
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 150,
        width: 400,
        modal: true,
        buttons: {
            "Yes": function () {
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "html",
                    data: {term_id: term_id},
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

