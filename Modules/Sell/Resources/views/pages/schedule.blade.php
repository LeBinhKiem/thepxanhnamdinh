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
        <div class="row mb-4">
            <div class="col-lg-4 col-md-4">
                <a href="{{ route("get.match.schedule") }}"
                   class="{{ $position == "schedule" ? "btn btn-primary-web" : "btn btn-light" }} w-100">
                    Lịch thi đấu
                </a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{ route("get.match.result") }}"
                   class="{{ $position == "result" ? "btn btn-primary-web" : "btn btn-light" }} w-100">
                    Kết quả</a>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="{{ route("get.match.rank") }}"
                   class="{{ $position == "rank" ? "btn btn-primary-web" : "btn btn-light" }} w-100">
                    Bảng xếp hạng</a>
            </div>
        </div>
        @if(empty($items))
            <div class="">Đang cập nhật dữ liệu</div>
        @else
            @foreach($items as $item)
                <div class="mb-3 bg-white shadow">
                    <div class="row">
                        <div class="col-lg-4 border-right">
                            <div class="p-3">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <div class="mt-2">
                                        <!-- Hiển thị tên giải đấu ở đây -->
                                        <span>{{ $item["league"] }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <span>{{ \Carbon\Carbon::parse($item["date"])->format('d-m-Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="d-flex align-items-center justify-content-end mt-3">
                                            <span>{{ $item["home_team"]["name"] }}</span>
                                            <img style="width: 20px"
                                                 src="{{ $item["home_team"]["image"] }}"
                                                 alt="" class="ms-2">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-center mt-3">
                                            <span class="me-3 ms-3 pt-1 pb-1 ps-3 pe-3"
                                                  style="background-color: rgba(180,172,206,.28); color: #472f92">-</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center mt-3">
                                            <img style="width: 20px"
                                                 src="{{ $item["away_team"]["image"] }}"
                                                 alt="">
                                            <span class="ms-2">{{ $item["away_team"]["name"] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@stop
