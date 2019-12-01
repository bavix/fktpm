<div class="col-12">
    <ul class="lightGallery list-unstyled row">
        @foreach($item->images as $_picture)
            <li style="padding-right: 1px; padding-left: 0; padding-bottom: 1px" class="col-4 col-sm-3 col-md-2" data-src="{{ app(\App\Services\ImageService::class)->xs($_picture) }}">
                <a href="#">
                    <img class="img-responsive" src="{{ app(\App\Services\ImageService::class)->placeholder() }}" data-src="{{ app(\App\Services\ImageService::class)->xl($_picture) }}"
                        style="object-position: center; object-fit: none"
                         title="Изображение #{{ $_picture->id }}"
                         alt="Изображение #{{ $_picture->id }}"
                        width="100%" height="110px" />
                </a>
            </li>
        @endforeach
    </ul>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css" />

<script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>

<script>
  $(document).ready(function() {
    $(".lightGallery").lightGallery();
  });
</script>
