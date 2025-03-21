@extends('base::layouts.master')
@section("breadcrumb")
@endsection
@section("css")
    <style>
        .bg-custom {
            background-color: #f8f9fe !important;
        }
    </style>
@endsection
@section("script")
    <script src="{{ asset("plugins/chart-js/chart.min.js") }}"></script>
     <script>
        $(document).ready(function () {
            new Chart(document.getElementById('chartUser'), {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Số người tạo',
                        data: {!! json_encode($dataChart["dataChartLineAccount"]) !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Ngày'
                            },
                            ticks: {
                                maxRotation: 360,
                                minRotation: 360,
                                padding: 10,
                                autoSkip: true,
                                maxTicksLimit: 12
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        })
    </script>
@endsection
@section('content')
     <div class="p-3">
        <h1>Thống kê báo cáo</h1>
        <p class="opacity-100">Nơi phân tích dữ liệu</p>
        <form action="" method="get" class="mb-3">
            <div class="form-inline">
                <select name="month" class="form-control form-control-sm">
                    <option value="">-- Chọn tháng --</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option {{ selectedCompareValue($query["month"] ?? "", $i) }} value="{{ $i }}">Tháng {{ $i }}</option>
                    @endfor
                </select>
                <select name="year" class="form-control form-control-sm ms-2">
                    <option value="">-- Chọn năm --</option>
                    @for($i = now()->year; $i >= 2024; $i--)
                        <option {{ selectedCompareValue($query["year"] ?? "", $i) }} value="{{ $i }}">Năm {{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary ms-2">Lọc</button>
            </div>

        </form>
        <div class="">
            <h3 class="my-4">
                Báo cáo tổng quan Tháng {{ $dataChart["monthCurrent"] ." Năm ". $dataChart["yearCurrent"] }}
            </h3>
            <div class=" row">
                <div class="col-md-4 mb-3">
                    <div class="shadow-lg bg-white p-3">
                        <div class="mb-3">
                            <i class="fa-solid fa-user bg-lighter p-2 rounded-circle"></i>
                        </div>
                        <div class="opacity-75 fs-14px">Người dùng đăng ký </div>
                        <div class="fs-28px fw-bold">{{ $userCreateInDay ?? 0 }} <span class="fs-12px">người</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="shadow-lg bg-white p-3">
                        <div class="mb-3">
                            <i class="fa-solid fa-clipboard-question bg-lighter p-2 rounded-circle"></i>
                        </div>
                        <div class="opacity-75 fs-14px">Lợi nhuận</div>
                        <div class="fs-28px fw-bold">{{ number_format($orderTotalInDay) ?? 0 }} <span class="fs-12px">VNĐ</span></div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="shadow-lg bg-white p-3">
                        <div class="mb-3">
                            <i class="fa-brands fa-blogger bg-lighter p-2 rounded-circle"></i>
                        </div>
                        <div class="opacity-75 fs-14px">Blog</div>
                        <div class="fs-28px fw-bold">{{ $blogCreateInDay ?? 0 }} <span class="fs-12px">bài đăng</span></div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="shadow-lg bg-white p-3">
                        <div class="mb-3">
                            <i class="fa-solid fa-user-plus bg-lighter p-2 rounded-circle"></i>
                        </div>
                        <div class="opacity-75 fs-14px">Cầu thủ</div>
                        <div class="fs-28px fw-bold">{{ $playerInDay ?? 0 }} <span class="fs-12px">cầu thủ</span></div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="shadow-lg bg-white p-3">
                        <div class="mb-3">
                            <i class="fa-solid fa-image bg-lighter p-2 rounded-circle"></i>
                        </div>
                        <div class="opacity-75 fs-14px">Media</div>
                        <div class="fs-28px fw-bold">{{ $mediaInDay ?? 0 }} <span class="fs-12px">video</span></div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="shadow-lg bg-white p-3">
                        <div class="mb-3">
                            <i class="fa-solid fa-cart-shopping bg-lighter p-2 rounded-circle"></i>
                        </div>
                        <div class="opacity-75 fs-14px">Đơn hàng</div>
                        <div class="fs-28px fw-bold">{{ $orderInDay ?? 0 }} <span class="fs-12px">Đơn hàng</span></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-5 p-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="p-3 bg-white shadow-sm ">
                        <h3>
                            Biểu đồ người dùng (Tháng {{ $dataChart["monthCurrent"] ."-". $dataChart["yearCurrent"] }})
                        </h3>
                        <div class="d-flex justify-content-center align-items-center" style="height: 300px">
                            <canvas id="chartUser"></canvas>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
