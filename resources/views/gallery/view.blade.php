<div class="col-12">
    <ul class="lightGallery list-unstyled row">
        @foreach($item->images as $_picture)
            <li style="padding-right: 1px; padding-left: 0; padding-bottom: 1px" class="col-4 col-sm-3 col-md-2" data-src="/storage/{{ $_picture->md() }}">
                <a href="#">
                    <img class="img-responsive" data-src="/storage/{{ $_picture->sm() }}"
                        style="object-position: center; object-fit: none"
                         title="Изображение #{{ $_picture->id }}"
                         alt="Изображение #{{ $_picture->id }}"
                        width="100%" height="110px" />
                </a>
            </li>
        @endforeach
    </ul>
</div>
