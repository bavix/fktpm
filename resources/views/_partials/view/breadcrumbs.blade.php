@if (count($breadcrumbs))

    <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" style="margin-top: 1rem;">
        @foreach ($breadcrumbs as $breadcrumb)

            <li itemprop="itemListElement" itemscope
                itemtype="http://schema.org/ListItem"
                class="breadcrumb-item">

                <a itemscope itemtype="http://schema.org/Thing"
                   itemprop="item" href="{{ $breadcrumb->url }}">
                    <span itemprop="name">{{ $breadcrumb->title }}</span>
                </a>
                <meta itemprop="position" content="{{ $loop->iteration }}" />
            </li>

        @endforeach
    </ol>

@endif
