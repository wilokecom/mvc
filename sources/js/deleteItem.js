function deleteItem($post_id)
{
    $(".deleteItem").each(function () {
        var $self = $(this);
        $("#dialog-confirm").dialog({
            resizable: false,
            height: 150,
            width: 400,
            modal: true,
            buttons: {
                "Yes": function () {
                    $.ajax({
                        url: "http://localhost:8088/mvc/post/delete",
                        type: "POST",
                        data: {post_id: $post_id},
                        success: function (data, status) {
                            $("#delete-result").html(data);
                            if (data === "Delete Success") {
                                $self.parent().parent().remove();
                            }
                        }
                    })
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    })
}

