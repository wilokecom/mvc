$(".pagination ").on("click", "a", "",function () {
    "use strict";
    let url = $(this).attr("href");
    console.log(url);
    $.ajax({
        url: url,
        type: "get",
        dataType: "json",
        success: function (result) {
            let html = "";
            let username = "";
            if (result.hasOwnProperty('abPostInfo') && result.hasOwnProperty('abUserInfo') &&
                result.hasOwnProperty('paging')) {
                username = result.abUserInfo["username"];
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    html += '<tr>';
                    html += '<td>' + username+'</td>';
                    html += '<td>' + abPostInfo["post_author"] + '</td>';
                    html += '<td>' + abPostInfo["ID"] + '</td>';
                    html += '<td>' + abPostInfo["post_title"] + '</td>';
                    html += '<td>' + abPostInfo["post_content"] + '</td>';
                    html += '<td>' + abPostInfo["post_status"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += " <td>" +
                        "<a href=\"http://localhost/mvc/post/edit?post-id="+ abPostInfo["ID"]+"\">"+
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        +"</a>"
                        +"</td>";
                    html += " <td>" +
                        "<a class=\"deleteItem\" href=\""+abPostInfo["ID"]+"\">"+
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        +"</a>"
                        +"</td>";
                    html +='</tr>';
                });
                //console.log(html);
                $('#content').html(html);
                $('.pagination').html(result.paging);
                //console.log(result);
                // Thay đổi URL trên website
                window.history.pushState({path: url}, '', url);
            }
        }
    });
    return false;
})
