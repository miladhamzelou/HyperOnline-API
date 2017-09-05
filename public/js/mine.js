$(document).ready(function (e) {
    $('.search-panel .dropdown-menu').find('a').click(function (e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#", "");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });

    $("#search").click(function () {
        var parameter = document.getElementById('search_param').value;
        var word = document.getElementById('word').value;

        if (!word)
            alert("عبارتی را برای جستجو وارد کنید");
        else if (parameter === "all")
            alert("فیلتر را تنظیم کنید");
        else
            document.location.href = "search?"
                + "word=" + word
                + "&parameter=" + parameter;
    });
});