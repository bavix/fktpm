$(function () {
    var myLazyLoad = new LazyLoad();
    var $lightGallery = $('.lightGallery');

    if ($lightGallery.length) {
        $lightGallery.lightGallery({
            thumbnail:true
        });
    }

    new Masonry(document.querySelector('.grid'), {
        itemSelector: '.grid-item'
    })
});
