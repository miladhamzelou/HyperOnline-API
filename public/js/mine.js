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
        // var token = $('meta[name=csrf-token]').attr('content');

        if (word && parameter !== "all")
            document.location.href = "search?"
                + "&word=" + word
                + "&parameter=" + parameter;
        else if (!word)
            swal(
                'Oooopse...',
                'عبارتی را برای جستجو وارد کنید',
                'error'
            );
        else if (parameter === "all")
            swal(
                'Oooopse...',
                'فیلتر را تنظیم کنید',
                'error'
            );
    });
});

function addCart($id) {
    var http = new XMLHttpRequest();
    var url = "/api/v1/getProduct";
    var params = "id=" + $id;
    http.open("POST", url, true);
    // http.setRequestHeader("Content-Type", "application/json");
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {
        if (http.readyState === 4 && http.status === 200) {
            alert(http.response);
        } else
            alert(http.status + ' ' + http.response)
    };
    http.send(params);

    swal({
        title: 'تعداد را تعیین کنید',
        type: 'question',
        input: 'range',
        inputAttributes: {
            min: 8,
            max: 120,
            step: 1
        },
        inputValue: 25
    })
}