//Press Menu button
$('#toggle').click(function () {
    $("#sidebar").sidebar('toggle');//Side bar toggle
});
//When press Category, Tag... on Sidebar
let coll = document.getElementsByClassName("term");//Get array have class="term"
let i;
for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
        let ClassContent = this.nextElementSibling;
        //Add the class active when press Category, Tag...
        this.classList.toggle("active");
        if (ClassContent.style.maxHeight) {
            ClassContent.style.maxHeight = null;
        } else {
            ClassContent.style.maxHeight = ClassContent.scrollHeight + "px";
        }
    });
}
//When press Add new Category
$("#add_new_category").on("click", "", "", function () {
    $(".add_new_category").toggle("active");
    if (this.style.maxHeight) {
        this.style.maxHeight = null;
    } else {
        this.style.maxHeight = this.scrollHeight + "px";
    }
});

//When press Add new Tag
$("#add_new_tag").on("click", "", "", function () {
    $(".add_new_tag").toggle("active");
    if (this.style.maxHeight) {
        this.style.maxHeight = null;
    } else {
        this.style.maxHeight = this.scrollHeight + "px";
    }
});

