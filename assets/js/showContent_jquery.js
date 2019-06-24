$(document).ready(function () {
    //html():Trả về nội dung các thành phần được chọn(bao gồm cả văn bản HTML)
    //Khác với text():Không bao gồm mã html
    $(".read-more").each(function () {
        var $self = $(this);
        var readMoreHtml = $self.html();
        //Trả về văn bản từ 0->100
        var lessText = readMoreHtml.substr(0, 100);
        //Nếu văn bản dài hơn 100
        if (readMoreHtml.length > 100) {
            //append:Nối thêm đường link vào cuối lessText
            //Hiển thị lessText
            //Class .read-more là parent của class.read-more-link
            $self.html(lessText).append(" <a href='#' class='read-more-link'>Read More</a>");
        } else {
            $self.html(readMoreHtml);//Hiển thị readMoreHtml
        }
        function handleReadMore(event)
        {
            event.preventDefault();//Phương thức event.preventDefault () ngăn hành động mặc định của một phần tử xảy ra(url)
            //Chọn class .read-more
            //Hiển thị đầy đủ readMoreHtml
            //Nối thêm đường link Show Less
            $self.html(readMoreHtml).append(" <a href='#' class='show-less-link'>Show Less</a>");
        }
        //.on: Sự kiện click cho class .read-more-link
        $self.on("click", ".read-more-link", handleReadMore);

        //.on: Sự kiện click cho class .show-less-link
        $self.on("click", ".show-less-link", function (event) {
            event.preventDefault();//Phương thức event.preventDefault () ngăn hành động mặc định của một phần tử xảy ra.
            //Chọn class .read-more
            //Hiển thị readMoreHtml từ 0->100
            //Nối thêm đường link Show More
            $self.html(readMoreHtml.substr(0, 100)).append(" <a href='#' class='read-more-link'>Show More</a>");
        });
    });
});
