@extends("sell::layouts.master")
@section("css")
    <style>


        .img-radius-top {
            height: 480px;
            object-fit: cover;
            object-position: center center;
            border-radius: 180px 180px 10px 10px;
        }

        .avatar {
            vertical-align: middle;
            width: 170px;
            height: 200px;
            border-radius: 0;
        }
        
    </style>
@stop
@section("content")
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-lg-6 col-md-6">
                <a href="{{ route("get.formation.coaches") }}"
                   class="{{ $position == "coaches" ? "btn btn-primary-web" : "btn btn-light" }} w-100">
                    Ban huấn luyện</a>
            </div>
            <div class="col-lg-6 col-md-6">
                <a href="{{ route("get.formation.player") }}"
                   class="{{ $position == "player" ? "btn btn-primary-web" : "btn btn-light" }} w-100">
                Đội 1</a>
            </div>
        </div>
        <div class="row">
            @foreach($items as $item)
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="bg-white shadow">
                        <div class="bg-primary-web p-3 text-white">
                            @if($position == "player")
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold text-center me-4" style="width: 50px; color: orange; font-size: 50px">
                                        {{ $item->shirt_number }}
                                    </div>
                                    <div class="">
                                        <div class="fw-bold fs-20px" style="color: orange">
                                            {{ $item->name }}
                                        </div>
                                        <div class="">{{ $item->position }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="fw-bold fs-20px" style="color: orange">
                                    {{ $item->name }}
                                </div>
                                <div class="">{{ $item->position }}</div>
                            @endif
                        </div>
                        <div class="row p-3">
                            <div class="col-lg-6">
                                <div class="border-bottom pb-1 mb-2">Ngày sinh: {{ date('d-m-Y', strtotime($item->birth_day))}}</div>
                                @if($position == "player")
                                    <div class="border-bottom pb-1 mb-2">Chiều cao: {{ $item->height }}</div>
                                    <div class="border-bottom pb-1 mb-2">Cân nặng: {{ $item->weight }}</div>
                                @endif
                                <div class="border-bottom pb-1 mb-2">Quê quán: {{ $item->address }}</div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <div class="">
                                    <img src="{{ render_url_upload($item->avatar) }}" class="avatar" alt="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@stop

