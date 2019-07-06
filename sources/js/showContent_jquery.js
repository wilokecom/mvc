$(document).ready(function () {
    "use strict";
    $(".read-more").each(function () {
        let $self = $(this);
        let readMoreHtml = $self.html();
        let lessText = readMoreHtml.substr(0, 100);
        if (readMoreHtml.length > 100) {
            $self.html(lessText).append(" <a href='#' class='read-more-link'>Read More</a>");
        } else {
            $self.html(readMoreHtml);//Hiển thị readMoreHtml
        }
        function handleReadMore(event)
        {
            event.preventDefault();
            $self.html(readMoreHtml).append(" <a href='#' class='show-less-link'>Show Less</a>");
        }
        $self.on("click", ".read-more-link", handleReadMore);
        $self.on("click", ".show-less-link", function (event) {
            event.preventDefault();
            $self.html(readMoreHtml.substr(0,100)).append(" <a href='#' class='read-more-link'>Show More</a>");
        });
    });
});
