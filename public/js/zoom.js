$(function () {

    var options = {
        min: 10,
        max: 15,
        current: undefined
    };

    var $plus = $('.zoom[data-type=0]');
    var $minus = $('.zoom[data-type=1]');

    watch(options, 'current', function (prop, action, difference) {

        console.log(arguments);

        bavix.local.set('fontSize', difference);

        $plus.removeClass('disabled');
        $minus.removeClass('disabled');

        if (difference <= options.min) {
            $minus.addClass('disabled');
        }

        if (difference >= options.max) {
            $plus.addClass('disabled');
        }

        $('body').css('font-size', (difference / 10) + 'rem');

    });

    options.current = bavix.local.get('fontSize', options.min);

    $('.zoom').click(function (e) {
        e.preventDefault();

        var type = $(this).data('type');

        switch (type) { // todo
            case 0:
                options.current++;
                break;

            case 1:
                options.current--;
                break;
        }

        options.current = Math.min(
            options.max,
            Math.max(options.current, options.min)
        );

        return false;
    });

});
