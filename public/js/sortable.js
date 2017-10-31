;(function () {
    'use strict';

    // gallery /*
    jQuery.fn.extend({
        'gallerySortable': function (options) {
            if (typeof Sortable === 'function')
            {
                const settings = $.extend({
                    url: '/admin/images',
                    method: 'PUT',
                    handle: '.move-handler',
                    animation: 150,
                    selector: '.image',
                }, options);

                const gallery = $(this);

                this.each(function () {
                    Sortable.create(this, {
                        handle: settings.handle,
                        animation: settings.animation,
                        onUpdate: function (evt) {
                            const ids = [];
                            gallery.find(settings.selector).each(function (i, e) {
                                ids.push($(e).data('id'));
                            });
                            $.ajax({
                                method: settings.method,
                                headers: {
                                    'X-CSRF-TOKEN': LA.token
                                },
                                url: settings.url,
                                data: {
                                    ids: ids
                                },
                                success: function (data) {
                                    toastr.info('Success!');
                                },
                                error: function () {
                                    toastr.warning('Error!');
                                }
                            });
                        },
                    });
                });
            }
        },
        'galleryDeleteImage': function (options) {

            const settings = $.extend({
                handle: '.delete-image',
                url: '/admin/images',
                method: 'DELETE',
                selector: '.image',
                success: {
                    title: 'Deleted!',
                    html: 'Your file has been deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1000
                },
                prompt: {
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }
            }, options);

            this.find(settings.handle).click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                const image = $(this).closest(settings.selector);
                swal(settings.prompt, function () {
                    console.log(image.data('id'));
                    $.ajax({
                        method: settings.method,
                        headers: {
                            'X-CSRF-TOKEN': LA.token
                        },
                        url: settings.url,
                        data: {
                            id: image.data('id')
                        },
                        success: function (data) {
                            console.dir(data);
                            image.remove();
                            swal(settings.success);
                        }
                    });
                });
            });
        },
    });
    // */ gallery

})();
