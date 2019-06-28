$(".deleteItem").click(function (event) {
    event.preventDefault();
     var post_id = $(this).attr("href");
    // console.log(post_id);

    // $(".deleteItem").each(function () {
    //
    // })

    var $self = $(this);
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
                    //dataType: "html",
                    data: {post_id: post_id},
                    success: function (data, status) {
                        $("#delete-result").html(data);
                        if (data === "Delete Success") {
                            $self.parent().parent().remove();
                        }
                    }
                })
                //Đóng hộp thoại
                $(this).dialog("close");
            },
            Cancel: function () {
                //Đóng hộp thoại
                $(this).dialog("close");
            }
        }
    });
})

