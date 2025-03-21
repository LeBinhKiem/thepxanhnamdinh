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

        .table thead th {
            border-bottom: white 1px solid;
            border-top: none;
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
        @if(empty($ranksByYear))
            <div class="">Đang cập nhật dữ liệu</div>
        @else

        <div class="float-end">
            <label for="yearSelect">Chọn mùa giải:</label>
            <select id="yearSelect" class="form-select-sm">
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year-1}} / {{$year}}</option>
                @endforeach
            </select>
        </div>

        <div id="tournament" class="mt-5 d-flex align-items-center"></div>

        <table class="table my-4" id="rankTable"></table>

        @endif
    </div>
@stop


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const yearSelect = document.getElementById('yearSelect');
            const rankTable = document.getElementById('rankTable');
            const tournament = document.getElementById('tournament');

            function updateRank(year) {
                // Dữ liệu từ controller
                const ranks = @json($ranksByYear);

                // Kiểm tra dữ liệu
                console.log('Dữ liệu bảng xếp hạng:', ranks);

                // Lấy dữ liệu cho năm được chọn
                const selectedRanks = ranks[year] || [];
                
                const selectedTournament = ranks[year] || [];

                // Tạo HTML cho bảng
                let html = `
                    <tr>
                        <th scope="col">Thứ hạng</th>
                        <th scope="col">Câu lạc bộ</th>
                        <th scope="col" class="text-center">Trận</th>
                        <th scope="col" class="text-center">Thắng</th>
                        <th scope="col" class="text-center">Thua</th>
                        <th scope="col" class="text-center">Hòa</th>
                        <th scope="col" class="text-center">Điểm</th>
                    </tr>
                `;
                
                let logoTournament =``;

                selectedRanks.forEach((rank, index) => {
                    html += `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>
                                <img src="${rank.footballTeamId?.image}"
                                    style="width: 30px;height: 30px;">
                                ${rank.footballTeamId?.name}
                            </td>
                            <td class="text-center">${rank.numberOfMatchPlayerd}</td>
                            <td class="text-center">${rank.numberOfMatchWin}</td>
                            <td class="text-center">${rank.numberOfMatchLost}</td>
                            <td class="text-center">${rank.numberOfMatchDrawn}</td>
                            <td class="text-center">${rank.totalScore}</td>
                        </tr>
                    `;
                });

                if (selectedTournament.length > 0) {
                    logoTournament = `
                    <img src="${selectedTournament[0].tournamentId?.image}" style="width: 100px; height: 48px;">
                    <div class="ms-3 fw-bolder fs-2">${selectedTournament[0].tournamentId?.name}</div>
                    `;
                }

                // Cập nhật nội dung bảng
                rankTable.innerHTML = html;
                tournament.innerHTML = logoTournament;
            }

            // Xử lý sự kiện thay đổi của thẻ select
            yearSelect.addEventListener('change', (e) => {
                updateRank(e.target.value);
            });

            // Khởi tạo với năm đầu tiên
            if (yearSelect.value) {
                updateRank(yearSelect.value);
            }
        });
    </script>
