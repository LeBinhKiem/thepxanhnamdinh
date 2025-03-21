<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-5">
    <div class="bg-white p-3 shadow">
        <a href="{{ route("get.sell.detail", $item->id) }}">
            <img src="{{ render_url_upload($item->image) }}" style="height: 300px; width: 100%; object-fit: cover" alt="">
            <div class="mt-3">
                <div class="fw-light text-center fs-14px mb-2 text-primary-web fw-bold">{{ $item->category->name }}</div>
                <div class="fw-bold second-row-dot text-center mb-2 text-dark">{{ $item->name }}</div>
                <div class="d-flex justify-content-center align-items-center text-light mb-3">
                    @for($star = 1; $star <=5 ; $star++)
                        <i class="fa-solid fa-star {{ $star <= $item->vote ? "text-warning"  : "text-gray"}}"></i>
                    @endfor
                </div>
                <div class="fw-bold text-body text-center">
                    @if($item->percent_sale > 0)
                        <span class="strikethrough text-gray me-1">
                        {{ number_format($item->price) }} VNĐ
                </span>
                    @endif
                    {{ number_format($item->price * (100 - $item->percent_sale) / 100) }} VNĐ
                </div>
            </div>
        </a>
    </div>
</div>