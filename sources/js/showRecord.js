// All records
$("#container").on('click', '#all', '', function (event) {
    "use strict";
    let url = HomeURL + "user/dashboard?display=all";
    event.preventDefault();
    $("#all").attr("class", "active-item");
    $("#mine").attr("class", "item");
    $.ajax({
        url: url,
        types: "GET",
        dataType: "json",
        success: function (result) {
            let html = "";
            if (Object.values(result.abPostInfo).length && Object.values(result.abUserInfo).length
                && Object.values(result.paging).length) {
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    html += '<tr>'
                    html += '<td>' + username + '</td>';
                    html += '<td>' + abPostInfo["post_author"] + '</td>';
                    html += '<td>' + abPostInfo["ID"] + '</td>';
                    html += '<td>' + abPostInfo["post_tittle"] + '</td>';
                    html += '<td class=\"read-more\">' + abPostInfo["post_content"] + '</td>';
                    html += '<td>' + abPostInfo["post_status"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += "<td>" +
                        "<a href=\"http://localhost:8088/mvc/post/edit/" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost:8088/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    html += " <td>" +
                        "<a class=\"deleteItem\" href=\"" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost:8088/mvc/sources/icon/icon_delete.png\">"
                        + "</a>" /
                        +"</td>";
                    html += '</tr>';
                })
            }
        }
    })
})

//Mine Record
$("#container").on('click', '#mine', '', function (event) {
    "use strict";
    let url = HomeURL + "user/dashboard?display=mine";
    event.preventDefault();
    $("#all").attr("class", "item");
    $("#mine").attr("class", "active-class");
    $.ajax({
        url: url,
        types: "GET",
        dataType: "json",
        success: function (result) {
            let html = "";
            if (Object.values(result.abPostInfo).length && Object.values(result.abUserInfo).length
                && Object.values(result.paging).length) {
                $.each(result["abPostInfo"],function (key,abPostInfo) {
                    html += '<tr>'
                    html += '<td>' + username + '</td>';
                    html += '<td>' + abPostInfo["post_author"] + '</td>';
                    html += '<td>' + abPostInfo["ID"] + '</td>';
                    html += '<td>' + abPostInfo["post_tittle"] + '</td>';
                    html += '<td class=\"read-more\">' + abPostInfo["post_content"] + '</td>';
                    html += '<td>' + abPostInfo["post_status"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += '<td>' + abPostInfo["post_type"] + '</td>';
                    html += "<td>" +
                        "<a href=\"http://localhost:8088/mvc/post/edit/" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost:8088/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    html += " <td>" +
                        "<a class=\"deleteItem\" href=\"" + abPostInfo["ID"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost:8088/mvc/sources/icon/icon_delete.png\">"
                        + "</a>" /
                        +"</td>";
                    html += '</tr>';
                })
            }

        }
    })
})

