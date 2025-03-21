@extends("sell::layouts.master")
@section("css")
    <style>
        .border-left {
            border-color: #ff6e4e !important;
            border-width: 3px !important;
        }

        .table thead th {
            border-bottom: white 1px solid;
            border-top: none;
        }

        .table > :not(caption) > * > * {
            background-color: rgb(50 113 181);
            color: #fff;
        }
    </style>
@stop
@php
    $info = \Illuminate\Support\Facades\DB::table("info")->first();
@endphp
@section("content")
    <div class="container position-relative d-flex justify-content-center" style="margin-bottom: 200px">
        <div class="row">
            <img class="w-100" src="{{ asset("images/background_home.jpg") }}">
        </div>
        <div class="bg-primary-web position-absolute" style="bottom: -146px;
        width: 1000px;
        min-height: 300px; opacity:0.85;">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12  text-white">
                    <div class="p-3">
                        <div class="text-center fw-bold mb-3" style="color: #ff6e4e">Trận kế tiếp</div>
                        @if($nextMatch)
                            {{-- <div class="text-center mb-5" style="font-size: 24px;">
                                <p class="mb-0" style="font-weight: bold;">{{ $nextMatch['league'] }}</p>
                                <p class="mb-1">{{ \Carbon\Carbon::parse($nextMatch["date"])->format('d/m/Y') }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $nextMatch['home_team']['image'] }}" alt="" style="width: 100px; object-fit: cover;">
                                </div>
                                <span style="font-size: 36px; font-weight: bold;">{{ \Carbon\Carbon::parse($nextMatch["date"])->format('H:i') }}</span>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $nextMatch['away_team']['image'] }}" alt="" style="width: 100px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <a class="btn border text-white" href="https://datve.clbnamdinh.vn/" target="_blank" rel="noopener noreferrer">Mua Vé</a>
                            </div> --}}
                        @else
                            <div class="text-white text-center"> 
                                <div class="text-center">Đang cập nhật</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                    <div class="p-3">
                        <div class="text-center fw-bold mb-3" style="color: #ff6e4e">Bảng xếp hạng</div>
                        <div class="text-white">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Thứ hạng</th>
                                    <th scope="col">Câu lạc bộ</th>
                                    <th scope="col" class="text-center">Trận</th>
                                    <th scope="col" class="text-center">Điểm</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ranks as $index => $rank)
                                    @if($index > 3)
                                        @break
                                    @endif
                                    <tr>
                                        <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                        <td>
                                            <img src="{{ $rank->footballTeamId->image }}"
                                                 style="width: 30px;height: 30px;">
                                            {{ $rank->footballTeamId->name }}
                                        </td>
                                        <td class="text-center" class="text-center">{{ $rank->numberOfMatchPlayerd }}</td>
                                        <td class="text-center" class="text-center">{{ $rank->totalScore }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <a href="{{ route("get.match.rank") }}" class="text-white"><i
                                            class="fa-solid fa-chevron-down"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5 pb-5 bg-primary-web">
        <div class="mt-5 container">
            <a href="{{ route("get.introduce.index") }}" class="border-left ps-3 fs-3 fw-semibold" style="color: #ff6e4e">
                Giới thiệu >>
            </a>
            <div class="row mt-4">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3 text-white">
                    @php
                        $info->introduce = explode(".", $info->introduce);
                        echo $info->introduce[0] ?? "";
                    @endphp
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <img src="{{ asset("images/image2.jpg") }}" class="w-100" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5 pb-5">
        <div class="container mt-5">
            <a href="{{ route("get.media.index") }}" class="border-left ps-3 fs-3 fw-semibold" style="color: #ff6e4e">
                Video >>
            </a>
            <div class="row mt-5">
                @foreach($medias as $media)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                        <div data-bs-toggle="modal" data-bs-target="#youtubeModal" data-ytb="{{ $media->youtube }}"
                             class="bg-white d-flex flex-column justify-content-center align-items-center h-100 shadow pe-auto">
                            <img src="{{ render_url_upload($media->image) }}" class="w-100"
                                 style="min-height:300px; object-fit: cover; " alt="Ảnh blog"
                                 onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                            >
                            <div class="p-4 w-100">
                                <div href=""
                                     class="fs-18px three-dot w-100 fw-bold text-brown">
                                    {{ limit_text($media->title, 50) }}
                                </div>
                                <div class=" mt-2 fs-13px text-end">
                                    {{ calculate_time($media->updated_at) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="pt-5 pb-5 bg-primary-web">
        <div class="container mt-5">
            <a href="{{ route("get.sell.search") }}" class="border-left ps-3 fs-3 fw-semibold" style="color: #ff6e4e">
                Sản phẩm >>
            </a>
            <div class="row mt-5">
                @foreach($items as $item)
                    @include("sell::items.item_product", ["item" => $item])
                @endforeach
            </div>
        </div>
    </div>

    <div class="pb-5">
        <div class="container mt-5 ">
            <a href="{{ route("get.blog.search") }}" class="border-left ps-3 fs-3 fw-semibold" style="color: #ff6e4e">
                Tin tức >>
            </a>
            <div class="row mt-5">
                @foreach($blogs as $blog)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                        <div
                                class="bg-white d-flex flex-column justify-content-center align-items-center h-100 shadow">
                            <img src="{{ render_url_upload($blog->logo) }}" class="w-100"
                                 style="height:250px; object-fit: cover; " alt="Ảnh blog"
                                 onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                            >
                            <div class="p-4 w-100">
                                <a href="{{ route("get.blog.detail", $blog->slug) }}"
                                   class="fs-18px three-dot w-100 fw-bold text-brown">
                                    {{ limit_text($blog->title, 100) }}
                                </a>
                                <div class="mt-2 three-dot w-100">
                                    {{ limit_text($blog->short_description, 100) }} 
                                </div>
                                <div class=" mt-2 fs-13px text-end">
                                    {{ calculate_time($blog->created_at) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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