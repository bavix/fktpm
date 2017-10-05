<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>

    <div class="col-sm-8">

        @include('admin::form.error')

        <ul id="{{ $id }}" class="list-unstyled row">
            @foreach($_documents as $_document)
                <li>
                    <a href="/upload/{{ $_document->src }}" download="{{ $_document->title ? : basename($_document->src) }}">
                        {{ $_document->name ? : basename($_document->src) }}
                    </a>

                    <a class="pull-right" href="#"
                       data-id="{{ $_document->id }}"
                       data-model="{{  \get_class($_document->pivot->pivotParent) }}">
                        <i class="fa fa-trash"></i>
                        <span>удалить</span>
                    </a>
                </li>
            @endforeach
        </ul>

        @include('admin::form.help-block')

    </div>
</div>

@if (isset($_document))
    <script>
        $('#{{ $id }} a[data-id]').click(function (e) {
            e.preventDefault();
            var $button = $(this);

            $.ajax({
                url: '{{ route('doc.trash', [], false) }}'
                , data: {
                    model: $button.data('model')
                    , itemId: '{{ $_document->pivot->pivotParent->id }}'
                    , documentId: $button.data('id')
                    , _token: '{{ csrf_token() }}'
                }
                , method: 'delete'
                , success: function () {
                    $button.parent().remove();
                }
            });
        });
    </script>
@endif
