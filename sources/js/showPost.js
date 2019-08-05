//User/Dashboard/display=all
$("#container").on("click", "#all", "", function (event) {
    "use strict";
    let url=HomeURL+"user/dashboard?display=all";
    event.preventDefault();
    $("#all").attr("class", "active item");
    $("#mine").attr("class", "item");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: {},
        success: function (result) {
            let dashboard = "";
            //User/Dashboard
            if (result.hasOwnProperty('abPostInfo') && result.hasOwnProperty('paging')) {
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    dashboard += '<tr>';
                    dashboard += '<td>' + abPostInfo["username"] +'</td>';
                    dashboard += '<td>' + abPostInfo["post_author"] + '</td>';
                    dashboard += '<td>' + abPostInfo["ID"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_title"] + '</td>';
                    dashboard += '<td class=\"read-more\">' + abPostInfo["post_content"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_status"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_type"] + '</td>';
                    dashboard += '<td>' + "" + '</td>';
                    dashboard += '<td>' + abPostInfo["category"] + '</td>';
                    dashboard += '<td>' + abPostInfo["tag"] + '</td>';
                    dashboard += " <td>" +
                        "<a href=\"http://localhost/mvc/post/edit?post-id=" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    dashboard += " <td>" +
                        "<a class=\"deletePost\" href=\"" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        + "</a>"
                        + "</td>";
                    dashboard += '</tr>';
                });
                $('#content').html(dashboard);
                $('.pagination').html(result.paging);
                // Thay đổi URL trên website
                window.history.pushState({path: url}, '', url);
                showMore();
            }
        }
    })
})
//User/Dashboard/
$("#container").on("click", "#mine", "", function (event) {
    "use strict";
    let url=HomeURL+"user/dashboard";
    event.preventDefault();
    $("#all").attr("class", "item");
    $("#mine").attr("class", "active item");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: {},
        success: function (result) {
            let dashboard = "";
            //User/Dashboard
            if (result.hasOwnProperty('abPostInfo')&&result.hasOwnProperty('paging')) {
                //username = result.abUserInfo["username"];
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    dashboard += '<tr>';
                    dashboard += '<td>' + abPostInfo["username"]+'</td>';
                    dashboard += '<td>' + abPostInfo["post_author"] + '</td>';
                    dashboard += '<td>' + abPostInfo["ID"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_title"] + '</td>';
                    dashboard += '<td class=\"read-more\">' + abPostInfo["post_content"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_status"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_type"] + '</td>';
                    dashboard += '<td>' + "" + '</td>';
                    dashboard += '<td>' + abPostInfo["category"] + '</td>';
                    dashboard += '<td>' + abPostInfo["tag"] + '</td>';
                    dashboard += " <td>" +
                        "<a href=\"http://localhost/mvc/post/edit?post-id=" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    dashboard += " <td>" +
                        "<a class=\"deletePost\" href=\"" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        + "</a>"
                        + "</td>";
                    dashboard += '</tr>';
                });
                $('#content').html(dashboard);
                $('.pagination').html(result.paging);
                // Thay đổi URL trên website
                window.history.pushState({path: url}, '', url);
                showMore();
            }
        }
    })
})
