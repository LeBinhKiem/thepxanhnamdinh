@extends('base::layouts.master')
@section("breadcrumb")

@endsection
@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("name",$query) }}" name="name" placeholder="Nhập tên cầu thủ"
               class="form-control form-control-sm me-2">
        <select class="form-control form-control-sm me-2" name="team">
            <option value="">--Chọn team--</option>
            @foreach(\Modules\Products\Enums\PlayerEnum::TEAM as $team => $value)
                <option {{ selectedCompareValue($query["team"] ?? [], $team) }}  value="{{ $team }}">{{ $value }}</option>
            @endforeach
        </select>
        <select class="form-control form-control-sm me-2" name="position">
            <option value="">--Chọn vị trí--</option>
            @foreach(\Modules\Products\Enums\PlayerEnum::POSITION as $position => $value)
                <option {{ selectedCompareValue($query["position"] ?? [], $position) }} value="{{ $position }}">{{ $value }}</option>
            @endforeach
        </select>
        <br>
        <div class="">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
            <a href="{{ route("get.players.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>
    <br>
    <a href="{{ route("get.players.create") }}" class="btn btn-primary float-end mb-3">
        <i class="fa-solid fa-plus"></i>
        Thêm mới
    </a>
    <div class="">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="5%" class="text-center">#</th>
                <th scope="col" width="20%">Cầu thủ</th>
                <th scope="col" width="20%">Thông số</th>
                <th scope="col" class="text-center" width="10%">Số áo</th>
                <th scope="col" width="10%">Vị trí</th>
                <th scope="col" width="15%">Team</th>
                <th scope="col" width="15%">Ngày cập nhật</th>
            </tr>
            </thead>
            <tbody>
            @if(count($items) > 0)
                @foreach($items as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm  btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route("get.players.edit", $item->id) }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            <span>Sửa</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="post" action="{{ route("post.players.delete") }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                                    class="dropdown-item">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Xóa</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <b class="d-block">
                                <a href="">{{ $item->name }}</a>
                            </b>
                            <div class="avatar avatar-lg rounded-circle mt-2  me-2">
                                <img alt="Image placeholder"
                                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                                     src="{{ render_url_upload($item->avatar) }}">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                #Ngày sinh: {{ date('d-m-Y', strtotime($item->birth_day))}}
                            </div>
                            <div class="mt-1">
                                #Chiều cao: {{ $item->height }} cm
                            </div>
                            <div class="mt-1">
                                #Cân nặng: {{ $item->weight }} kg
                            </div>
                            <div class="mt-1">
                                #Quê quán: {{ $item->address }}
                            </div>
                        </td>
                        <td class="text-center">{{ $item->shirt_number }}</td>
                        <td>{{ $item->position }}</td>
                        <td>{{ $item->team }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
        {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($items, $query) !!}
@endsection
