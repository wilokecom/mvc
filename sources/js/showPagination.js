$(".pagination").on("click", "a", "", function () {
    "use strict";
    let url = $(this).attr("href");
    $.ajax({
        url: url,
        type: "get",
        dataType: "json",
        success: function (result) {
            let dashboard = "";
            let taxonomy = "";
            const capitalize = (s) => {
                if (typeof s !== 'string') {
                    return "";
                }
                return s.charAt(0).toUpperCase() + s.slice(1);
            }
            //User/Dashboard
            if (result.hasOwnProperty('abPostInfo') && result.hasOwnProperty('paging')) {
                $.each(result['abPostInfo'], function (key, abPostInfo) {
                    dashboard += '<tr>';
                    dashboard += '<td>' + abPostInfo["username"] + '</td>';
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
                showMore();
            }
            //Category(Tag)/Dashboard
            if (result.hasOwnProperty('abTaxonomyInfo') && result.hasOwnProperty('paging')) {
                $.each(result['abTaxonomyInfo'], function (key, abTaxonomyInfo) {
                    taxonomy += '<tr>';
                    taxonomy += '<td>' + abTaxonomyInfo["term_name"] + '</td>';
                    taxonomy += '<td>' + abTaxonomyInfo["description"] + '</td>';
                    taxonomy += '<td>' + abTaxonomyInfo["slug"] + '</td>';
                    taxonomy += '<td>' + abTaxonomyInfo["count_taxonomy"] + '</td>';
                    taxonomy += " <td>" +
                        "<a href=\"http://localhost/mvc/" + result.sTaxonomy + "/edit?" + result.sTaxonomy + "-name=" + abTaxonomyInfo["term_name"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_edit.png\">"
                        + "</a>"
                        + "</td>";
                    taxonomy += " <td>" +
                        "<a class=\"delete" + capitalize(result.sTaxonomy) + "\"href=\"" + abTaxonomyInfo["term_id"] + "\">" +
                        "<img width=\"16\" src=\"http://localhost/mvc/sources/icon/icon_delete.png\">"
                        + "</a>"
                        + "</td>";
                    taxonomy += '</tr>';
                });
                //Change content
                $('#content').html(taxonomy);
                //Change pagination
                $('.pagination').html(result.paging);
                window.history.pushState({path: url}, '', url);
            }
        }
    });
    return false;
})

