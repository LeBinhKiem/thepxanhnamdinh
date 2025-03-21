<div class="p-3 border-1 border rounded-3 mb-4 shadow">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <img
                src="{{ render_url_upload($item->admin->logo) }}"
                onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                alt=""
                style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover" class="border">
            <b class="fs-13px ms-2">{{ $item->admin->name }} </b>
        </div>

    </div>
    <div class="row flex-wrap-reverse">
        <div class="text-justify  {{ isset($item_short) && $item_short ? "col-lg-12" : "col-lg-9" }} mt-3">
            <a href="{{ route("get.blog.detail", $item->slug) }}" class="fw-bold text-brown"> {{ $item->title }}</a>
            <div class="mt-1 fs-14px">
                {{ limit_text($item->short_description, 150) }}
            </div>
            <div class="fs-12px mt-2">
                {{ calculate_time($item->created_at) }} -
            </div>
        </div>
        <div class="mt-3 col-lg-3 {{ isset($item_short) && $item_short ? "hide" : "" }}">
            <img
                style="width: 100%; max-width: 200px; max-height: 150px; border-radius: 15px; object-fit: cover"
                src="{{ render_url_upload($item->logo) }}"
                onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                alt="">
        </div>
    </div>
</div>
