import Autolinker from 'autolinker';

$(document).ready(function () {

    $('.autolink').each(function()
    {
        $(this).html(Autolinker.link($(this).html(), {
            newWindow: true,
        }))
    });
});
