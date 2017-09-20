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
    var url = "/api/v1/getProductByID/" + $id;
    http.open("GET", url, true);

    http.onreadystatechange = function () {
        if (http.readyState === 4 && http.status === 200) {
            var product = JSON.parse(http.responseText);

            swal({
                title: product.name + '\n' + 'تعداد را تعیین کنید',
                input: 'range',
                confirmButtonText: 'ثبت',
                inputAttributes: {
                    min: 1,
                    max: product.count,
                    step: 1
                },
                inputValue: 1
            }).then(function (c) {
                var http2 = new XMLHttpRequest();
                var p = "id=" + product.unique_id + "&count=" + c;
                url = "/addToCart?" + p;
                http2.open("GET", url, true);
                http2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                http2.send(null);
                http2.onreadystatechange = function () {
                    if (http2.readyState === 4 && http2.status === 200) {
                        window.location.href = "http://localhost/home";
                    }
                }
            })
        }
    };
    http.send(null);
}

function removeCart($id) {
    swal({
        title: 'آیا مطمپن هستید ؟',
        text: "محصول از سبد خرید حذف خواهد شد",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'حذف',
        cancelButtonText: 'لغو'
    }).then(function () {
        var http = new XMLHttpRequest();
        var p = "id=" + $id;
        url = "/removeFromCart?" + p;
        http.open("GET", url, true);
        http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        http.send(null);
        http.onreadystatechange = function () {
            if (http.readyState === 4 && http.status === 200) {
                window.location.href = "http://localhost/home";
            }
        }
    })
}