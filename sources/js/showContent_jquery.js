$(document).ready(function () {
    "use strict";

    function showMore() {
        $("#content").find(".read-more").each(function () {
            var $self = $(this);
            var readMoreHtml = $self.html();
            var lessText = readMoreHtml.substr(0, 100);
            if (readMoreHtml.length > 100) {
                $self.html(lessText).append(" <a href='#' class='read-more-link'>Read More</a>");
            } else {
                $self.html(readMoreHtml);//Hiển thị readMoreHtml
            }

            function handleReadMore(event){
                event.preventDefault();//Phương thức event.preventDefault () ngăn hành động mặc định của một phần tử xảy ra(url)
                $self.html(readMoreHtml).append(" <a href='#' class='show-less-link'>Show Less</a>");
            }

            $self.on("click", ".read-more-link", handleReadMore);
            $self.on("click", ".show-less-link", function (event) {
                event.preventDefault();//Phương thức event.preventDefault () ngăn hành động mặc định của một phần tử xảy ra.
                $self.html(readMoreHtml.substr(0, 100)).append(" <a href='#' class='read-more-link'>Show More</a>");
            });
        });
    }

    showMore();

    $(document).on('rehandleshowmore', function () {
        showMore();
    })
});
