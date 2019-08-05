$(".pagination ").on("click", "a", "",function (event) {
    event.preventDefault();
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
            console.log(result);
            // console.log(typeof result.abPostInfo === 'undefined')
            if (Object.values(result.abPostInfo).length &&  Object.values(result.abUserInfo).length && Object.values(result.paging).length)  {
                username = result.abUserInfo["username"];
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    html += '<tr>';
                    html += '<td>' + username+'</td>';
                    html += '<td>' + abPostInfo["post_author"] + '</td>';
                    html += '<td>' + abPostInfo["ID"] + '</td>';
                    html += '<td>' + abPostInfo["post_tittle"] + '</td>';
                    html += '<td class=\"read-more\">' + abPostInfo["post_content"] + '</td>';
                    html += '<td>' + abPostInfo["post_status"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += "<td>" +
                        "<a href=\"http://localhost:8088/mvc/post/edit?post-id="+ abPostInfo["ID"]+"\">"+
                        "<img width=\"16\" src=\"http://localhost:8088/mvc/sources/icon/icon_edit.png\">"
                        +"</a>"
                        +"</td>";
                    html += " <td>" +
                        "<a class=\"deleteItem\" href=\""+abPostInfo["ID"]+"\">"+
                        "<img width=\"16\" src=\"http://localhost:8088/mvc/sources/icon/icon_delete.png\">"
                    +"</a>"
                        +"</td>";
                    html +='</tr>';
                });
                console.log(html);
                $('#content').html(html);
                $('.pagination').html(result['paging']);
                window.history.pushState({path: url}, '', url);
                $(document).trigger('rehandleshowmore');
                }
            }
    });
    return false;
})



