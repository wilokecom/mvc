$(".pagination").on("click", "a", "", function () {
    "use strict";
    let url = $(this).attr("href");
    $.ajax({
        url: url,
        type: "get",
        dataType: "json",
        success: function (result) {
            let a=["hoc sinh","co giao","nha trương"];
            console.log(a);
            let dashboard = "";
            let username = "";
            let category = "";
            let tag = "";
            //User/Dashboard
            if (result.hasOwnProperty('abPostInfo') && result.hasOwnProperty('abUserInfo') &&
                result.hasOwnProperty('paging')) {
                username = result.abUserInfo["username"];
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    dashboard += '<tr>';
                    dashboard += '<td>' + username + '</td>';
                    dashboard += '<td>' + abPostInfo["post_author"] + '</td>';
                    dashboard += '<td>' + abPostInfo["ID"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_title"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_content"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_status"] + '</td>';
                    dashboard += '<td>' + abPostInfo["post_type"] + '</td>';
                    dashboard += '<td>' + "" + '</td>';
                    dashboard += '<td>' + abPostInfo["category"] + '</td>';
                    dashboard += '<td>' + abPostInfo["tag"] + '</td>';
                    dashboard += " <td>" +
                        "<a href=\"http://localhost/mvc/post/edit?post-id="+ abPostInfo["ID"]+"\">"+
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        +"</a>"
                        +"</td>";
                    dashboard += " <td>" +
                        "<a class=\"deletePost\" href=\""+abPostInfo["ID"]+"\">"+
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        +"</a>"
                        +"</td>";
                    dashboard += '</tr>';
                });
                $('#content').html(dashboard);
                $('.pagination').html(result.paging);
                // Thay đổi URL trên website
                window.history.pushState({path: url}, '', url);
            }
            //Category/Dashboard
            if (result.hasOwnProperty('abCategoryInfo') && result.hasOwnProperty('paging')) {
                $.each(result['abCategoryInfo'], function (key, abCategoryInfo) {
                    category += '<tr>';
                    category += '<td>' + abCategoryInfo["term_name"] + '</td>';
                    category += '<td>' + abCategoryInfo["description"] + '</td>';
                    category += '<td>' + abCategoryInfo["slug"] + '</td>';
                    category += '<td>' + abCategoryInfo["count_taxonomy"] + '</td>';
                    category += " <td>" +
                        "<a href=\"http://localhost/mvc/category/edit?category-name=" + abCategoryInfo["term_name"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    category += " <td>" +
                        "<a class=\"deleteCategory\" href=\"" + abCategoryInfo["term_id"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        + "</a>"
                        + "</td>";
                    category += '</tr>';
                });
                //Change content
                $('#content').html(category);
                //Change pagination
                $('.pagination').html(result.paging);
                window.history.pushState({path: url}, '', url);
            }
            //Tag/Dashboard
            if (result.hasOwnProperty('abTagInfo') && result.hasOwnProperty('paging')) {
                $.each(result['abTagInfo'], function (key, abTagInfo) {
                    tag += '<tr>';
                    tag += '<td>' + abTagInfo["term_name"] + '</td>';
                    tag += '<td>' + abTagInfo["description"] + '</td>';
                    tag += '<td>' + abTagInfo["slug"] + '</td>';
                    tag += '<td>' + abTagInfo["count_taxonomy"] + '</td>';
                    tag += " <td>" +
                        "<a href=\"http://localhost/mvc/tag/edit?tag-name=" + abTagInfo["tag_name"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    tag += " <td>" +
                        "<a class=\"deleteTag\" href=\"" + abTagInfo["term_id"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        + "</a>"
                        + "</td>";
                    tag += '</tr>';
                });
                //Change content
                $('#content').html(tag);
                //Change pagination
                $('.pagination').html(result.paging);
                window.history.pushState({path: url}, '', url);
            }
        }
    });
    return false;
})

