var $script = $(document.currentScript);
var color = 'visually-' + $script.data('color');
var font = 'f' + $script.data('font');

/**
 * @author rez1dent3
 * @year 2017
 * @company bavix
 * @site bavix.ru
 * @site babichev.net
 */
$(function () {

    var $poll = $('#poll');
    var $polls = $poll.data('count');

    var personal = false;

    $('.lightGallery').lightGallery({
        thumbnail:true
    });

    $poll.find('[type=radio]').change(function () {
        $poll.find('button').prop('disabled', $poll.serializeArray().length !== ($polls + 1));
    });

    $('form[method="POST"] [required]').change(function () {
        if (personal) {
            $('#personal-data').trigger('change');
        }
    });

    var $navBar = $('nav.navbar');

    function stickyInit() {
        var width = $(window).width(); // Change width to new width
        if (width >= 960) {
            $navBar.sticky({ topSpacing: 0 });
        } else {
            $navBar.unstick();
        }
    }

    // On Page Resize...
    $(window).resize(stickyInit);
    stickyInit();

    // validate form
    $('#personal-data').change(function () {

        personal = true;

        var checked = $(this).prop('checked');
        var $fields = $(this).parents('form[method="POST"]').find('[required]');

        $fields.each(function (_, field) {
            var $field = $(field);
            _ = $field.val();
            if (!_ || _.trim().length === 0) {
                checked = false;
                $field.removeClass('is-valid').addClass('is-invalid');
            } else {
                $field.removeClass('is-invalid').addClass('is-valid');
            }
        });

        $(this).prop('checked', checked);
        $('button[data-personal]').prop('disabled', !checked);
    });

    // send form
    $('form[method="POST"]').submit(function (e) {

        var $personal = $('#personal-data');
        var $form = $(this);

        if (!$personal.length)
        {
            return true;
        }

        e.preventDefault();

        if ($personal.prop('checked')) {
            $.ajax({
                url: location.href,
                method: 'POST',
                data: $(this).serializeArray(),
                success: function (response) {
                    if (response.result) {
                        swal('Successful', 'Форма отправлена успешно!', 'success');
                        $personal.prop('checked', false);
                        $form.find('.is-valid').removeClass('is-valid');
                        $form.trigger('reset');

                        personal = false;
                    } else {
                        swal('Oops...', 'Произошла ошибка, попробуйте позже!', 'error');
                    }
                },
                error: function () {
                    swal('Oops...', 'Произошла ошибка, попробуйте позже!', 'error');
                }
            })
        }
    });

    var halper = function (variable) {
        return function (e) {
            e.preventDefault();
            var $body = $('body');
            var $a = $(this);

            if ($a.hasClass('active')) {
                return;
            }

            $body.removeClass(variable);
            variable = $a.data('val');
            $body.addClass(variable);
            $a.parent().find('a').removeClass('active');
            $a.addClass('active');
            $.get($a.attr('href'));
        };
    };

    $('.visually-font a').click(new halper(font));
    $('.visually-color a').click(new halper(color));

    $('.visually-special a').click(function (e) {
        e.preventDefault();
        var $body = $('body');
        var $a = $(this);
        $a.parent().find('a').toggleClass('active');
        $body.toggleClass($a.data('val'));
        $.get($a.attr('href'));

        var $sel = $a.data('sel');

        if (typeof $sel !== "undefined") {
            if (!$sel) {
                $body.removeClass('visually-image');

                // reset buttons
                $('.visually-font a').removeClass('active').eq(0).click();
                $('.visually-color a').removeClass('active').eq(0).click();
            }
        }
    });

    // clipboard
    var clipboard = new Clipboard('button.clipboard');

    clipboard.on('success', function(e) {
        var $button = $(e.trigger);
        $button.tooltip('show');

        setTimeout(function () {
            $button.tooltip('dispose');
        }, 2300);

        e.clearSelection();
    });

    // share
    var Share = new (function () {

        var self = this;
        var title = $('title').text();
        var desc = $('meta[name="description"]').attr('content');
        var url = $('#shorter').val();
        var img = $('#qr-image').attr('src');

        this.vk = function() {
            var _url  = 'http://vk.com/share.php?';
            _url += 'url='          + encodeURIComponent(url);
            _url += '&title='       + encodeURIComponent(title);
            _url += '&description=' + encodeURIComponent(desc);
            _url += '&image='       + encodeURIComponent(img);
            _url += '&noparse=true';

            self.popup(_url);
        };

        this.facebook = function() {
            var _url  = 'http://www.facebook.com/sharer.php?s=100';
            _url += '&p[url]='       + encodeURIComponent(url);
            _url += '&p[title]='     + encodeURIComponent(title);
            _url += '&p[summary]='   + encodeURIComponent(desc);
            _url += '&p[images][0]=' + encodeURIComponent(img);

            self.popup(_url);
        };

        this.twitter = function() {
            var _url  = 'http://twitter.com/share?';
            _url += 'text='      + encodeURIComponent(
                desc.length > 100 ? desc.substr(0, 100) + '..' : desc
            );
            _url += '&url='      + encodeURIComponent(url);
            _url += '&counturl=' + encodeURIComponent(url);

            self.popup(_url);
        };

        this.popup = function(url) {
            window.open(url,'','toolbar=0,status=0,width=626,height=436');
        }

    })();

    $('[data-vk]').click(Share.vk);
    $('[data-facebook]').click(Share.facebook);
    $('[data-twitter]').click(Share.twitter);

    var $datePicker = $('.datepicker');

    if ($datePicker.length) {
        $datePicker.datepicker().datepicker( "option", "dateFormat", "dd.mm.yy" );
    }

    $('#autoAddress').click(function () {
        var $res = $('#residentialAddress');
        if ($(this).prop('checked')) {
            $res.val($('#registrationAddress').val()).parent().hide();
        } else {
            $res.val('').parent().show();
        }
    });

    $('#passportSerial').mask("99 99");
    $('#passportNumber').mask("999999");
    $('#passportDivision').mask("999-999");

    $('#phone').mask("+7 (999) 999-99-99");

    // ===== Scroll to Top ====
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });

    $('#return-to-top').click(function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });

    // form search
    $('#search').submit(function (e) {
        var validator = (this.query.value || '').trim().length > 0;

        if (!validator) {
            var $field = $(this.query);
            $field.addClass('is-invalid');
        }

        return validator;
    });

});
