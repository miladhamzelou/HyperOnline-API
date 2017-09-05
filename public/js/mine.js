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
        var token = $('meta[name=csrf-token]').attr('content');

        $.post('search', {
            _token: token,
            parameter: parameter,
            word: word
        })
            .fail(function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            });
    });
});