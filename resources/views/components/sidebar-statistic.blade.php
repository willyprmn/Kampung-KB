<div class="d-md-block row collapse" id="bd-docs-nav" style="">
    <nav class="bd-links" aria-label="Main navigation">

        <div class="bd-toc-item">
            <a class="bd-toc-link" href="#">
            Topik Tabel
            </a>
        </div>
        @include('components.include.statistic.custom-menu', ['items' => $menus->whereParent()])

    </nav>
</div>