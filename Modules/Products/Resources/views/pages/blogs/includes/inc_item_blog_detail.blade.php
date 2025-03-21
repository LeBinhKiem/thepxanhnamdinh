<div class="p-3 border rounded-3 mb-4 shadow-sm">
    <div class="d-flex align-items-center mb-3">
        <img
            src="{{ render_url_upload($item->admin->logo) }}"
            onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
            alt="{{ $item->admin->name }}"
            class="rounded-circle me-3"
            style="width: 45px; height: 45px; object-fit: cover;">
        <div>
            <b class="fs-14px">{{ $item->admin->name }}</b>
            <div class="fs-12px text-muted">
                {{ calculate_time($item->created_at) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <a href="{{ route('get.blog.detail', $item->slug) }}" class="text-dark fw-bold fs-16px">{{ $item->title }}</a>
            <p class="mt-2 fs-14px text-muted">
                {{ limit_text($item->short_description, 150) }}
            </p>
            <a href="{{ route('get.blog.detail', $item->slug) }}" class="btn btn-outline-primary mt-2">Xem bài viết</a>
        </div>
        <div class="col-lg-4">
            <img
                src="{{ render_url_upload($item->logo) }}"
                onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                alt="{{ $item->title }}"
                class="img-fluid rounded-3"
                style="object-fit: cover; height: 150px; width: 100%; border: 1px solid #ddd;">
        </div>
    </div>
</div>
