$(document).ready(function () {
    $('i.glyphicon-thumbs-up, i.glyphicon-thumbs-down').click(function () {
        var $this = $(this),
            c = $this.data('count');
        if (!c) c = 0;
        c++;
        $this.data('count', c);
        $('#' + this.id + '-bs3').html(c);
    });
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
});

function like() {
    var idea_id = document.getElementById('idea_id').value;
    var user_id = document.getElementById('user_id').value;

    $.post('like', {
            _token: $('meta[name=csrf-token]').attr('content'),
            idea_id: idea_id,
            user_id: user_id
        }
    )
        .done(function () {
            SnackBar();
        })
        .fail(function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " " + thrownError);
        });
}

function dislike() {
    var idea_id = document.getElementById('idea_id').value;
    var user_id = document.getElementById('user_id').value;

    $.post('dislike', {
            _token: $('meta[name=csrf-token]').attr('content'),
            idea_id: idea_id,
            user_id: user_id
        }
    )
        .done(function () {
            SnackBar();
        })
        .fail(function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " " + thrownError);
        });
}

function SnackBar() {
    var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function () {
        x.className = x.className.replace("show", "");
    }, 2000);
}