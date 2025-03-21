@extends("sell::layouts.master")
@section("css")
    <style>
        .border-left {
            border-color: #ff6e4e !important;
        }

        .img-radius-top {
            height: 480px;
            object-fit: cover;
            object-position: center center;
            border-radius: 180px 180px 10px 10px;
        }

    </style>
@stop
@section("content")
    <div class="container mt-5">
        <div class="row">
            @foreach($items as $media)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                    <div data-bs-toggle="modal" data-bs-target="#youtubeModal" data-ytb="{{ $media->youtube }}"
                         class="bg-white d-flex flex-column justify-content-center align-items-center h-100 shadow">
                        <img src="{{ render_url_upload($media->image) }}" class="w-100"
                             style="object-fit: cover; " alt="Ảnh blog"
                             onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                        >
                        <div class="p-4 w-100">
                            <div href=""
                                 class="fs-14px three-dot w-100 fw-bold text-brown">
                                {{ limit_text($media->title, 50) }}
                            </div>
                            <div class=" mt-2 fs-12px text-end">
                                {{ calculate_time($media->updated_at) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mb-4 d-flex justify-content-center">
            {{ $items->links() }}
        </div>
    </div>
    <div class="modal fade" id="youtubeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="youtubeVideo" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        // Khi modal được mở, gán URL video YouTube vào iframe
        $('#youtubeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Nút đã kích hoạt modal
            let youtube = button.attr("data-ytb");
            var modal = $(this);
            modal.find('#youtubeVideo').attr('src', youtube);
        });

        // Khi modal được đóng, xóa URL video YouTube khỏi iframe
        $('#youtubeModal').on('hide.bs.modal', function (event) {
            var modal = $(this);
            modal.find('#youtubeVideo').attr('src', '');
        });
    </script>
@stop