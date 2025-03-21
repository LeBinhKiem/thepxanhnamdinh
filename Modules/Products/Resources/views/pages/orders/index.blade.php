@extends('base::layouts.master')
@section("breadcrumb")
    {{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books") !!}--}}
@endsection
@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("name",$query) }}" name="name" placeholder="Nhập tên"
               class="form-control form-control-sm me-2">
        <select class="form-control form-control-sm me-2" name="status">
            <option value="">--Chọn trạng thái--</option>
            @foreach(\Modules\Products\Enums\OrderEnum::ARR_STATUS as $index => $value)
                <option {{ selectedCompareValue($query["status"] ?? [], $index) }}
                        value="{{ $index }}"> {{ $value["text"] }}
                </option>
            @endforeach
        </select>
        <br>
        <div class="">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
            <a href="{{ route("get.orders.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>
    <br>
    <div class="">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="5%" class="text-center">#</th>
                <th scope="col" width="35%">Người đặt</th>
                <th scope="col" width="10%">Phương thức</th>
                <th scope="col" width="15%" class="text-center">Tổng tiền</th>
                <th scope="col" class="text-center" width="15%">Trạng thái</th>
                <th scope="col" width="15%">Ngày tạo đơn</th>
            </tr>
            </thead>
            <tbody>
            @if(count($items) > 0)
                @php
                    $status = \Modules\Products\Enums\OrderEnum::ARR_STATUS;
                @endphp
                @foreach($items as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route("get.orders.detail", $item->id) }}"
                                           target="_blank"> <i class="fa-solid fa-eye"></i>
                                            Xem chi tiết</a>
                                    </li>
                                    @if($item->status == \Modules\Products\Enums\OrderEnum::WAITING_CONFIRM)
                                        <li>
                                            <form action="{{ route("post.orders.update") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{ \Modules\Products\Enums\OrderEnum::CONFIRM }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>{{ $status[\Modules\Products\Enums\OrderEnum::CONFIRM]["textBtn"] }}</span>
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route("post.orders.update") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{ \Modules\Products\Enums\OrderEnum::CANCEL }}">
                                                <button type="submit" class="dropdown-item"
                                                        onclick="return confirm('Bạn chắc chắn muốn hủy?')">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    <span>{{ $status[\Modules\Products\Enums\OrderEnum::CANCEL]["textBtn"] }}</span>
                                                </button>
                                            </form>
                                        </li>
                                    @elseif($item->status == \Modules\Products\Enums\OrderEnum::CONFIRM)
                                        <li>
                                            <form action="{{ route("post.orders.update") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{ \Modules\Products\Enums\OrderEnum::SUCCESS }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>{{ $status[\Modules\Products\Enums\OrderEnum::SUCCESS]["textBtn"] }}</span>
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route("post.orders.update") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{ \Modules\Products\Enums\OrderEnum::FAILURE }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    <span>{{ $status[\Modules\Products\Enums\OrderEnum::FAILURE]["textBtn"] }}</span>
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="">
                                #Họ tên: {{ $item->name  }}
                            </div>
                            <div class="fs-12px">
                                #Số điện thoại: {{ $item->number_phone }}
                            </div>
                            <div class="fs-12px">
                                #Địa chỉ: {{ $item->address }}
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $item->payment }}
                        </td>
                        <td class="text-center">
                            {{ number_format($item->total) }} VNĐ
                        </td>
                        <td class="text-center">
                            <span class="{{ $status[$item->status]["class"] }}">{{ $status[$item->status]["text"] }}</span>
                        </td>
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
