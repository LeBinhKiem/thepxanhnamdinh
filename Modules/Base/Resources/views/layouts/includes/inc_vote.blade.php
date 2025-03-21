<link rel="stylesheet" href='{{ asset("vendor/base/css/vote.min.css") }}'>
@if(empty($vote["current"]))
    <div class="wrapper">
        <div class="master col-lg-6 col-sm-12 col-ssm-12">
            <h5>Xếp hạng sản phẩm</h5>
            <small class="mb-3">Cho người khác biết về suy nghĩ của bạn?</small>
            @if(get_user_id())
                <form method="post" action="{{ route("post.vote.vote") }}">
                    @csrf
                    <div class="rating-component">
                        <div class="stars-box">
                            <i class="star fa fa-star" title="1 sao" data-message="Kém" data-value="1"></i>
                            <i class="star fa fa-star" title="2 sao" data-message="Quá tệ" data-value="2"></i>
                            <i class="star fa fa-star" title="3 sao" data-message="Chất lượng trung bình"
                               data-value="3"></i>
                            <i class="star fa fa-star" title="4 sao" data-message="Tốt" data-value="4"></i>
                            <i class="star fa fa-star" title="5 sao" data-message="Quá tốt" data-value="5"></i>
                        </div>
                        <div class="starrate" style="height: 0; margin-bottom: 10px;">
                            <label>
                                <input class="ratevalue" type="hidden" name="star" value=""/>
                            </label>
                        </div>
                    </div>
                    <div class="feedback-tags hide">
                        <div class="tags-box">
                            <input type="text" class=" form-control p-3" name="description"
                                   placeholder="Nhập đánh giá (Không bắt buộc)">
                            <input type="hidden" name="model_id" value="{{ $model_id }}"/>
                            <input type="hidden" name="model" value="{{ $model }}"/>
                        </div>
                    </div>
                    <div class="button-box mt-3 mb-3">
                        <button type="submit" class="done btn btn-warning">Đánh giá</button>
                    </div>
                </form>
            @else
                <a href="{{ route("get.auth_user.login") }}">
                    Đăng nhập để có thể đánh giá
                </a>
            @endif
        </div>
    </div>
@endif
<div class="row flex-wrap-reverse">
    <div class="col-lg-12">
        @if(!empty($vote["current"]))
            <p class="fw-bold fs-18px">Đánh giá của bạn</p>
            <div class="bg-white p-3 shadow-sm mb-4 position-relative">
                <div class="dropdown">
                    <button class="btn btn-sm  btn-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="post" action="{{ route("post.vote.delete") }}">
                                @csrf
                                <input type="hidden" name="model_id" value="{{ $model_id }}">
                                <input type="hidden" name="model" value="{{ $model }}">
                                <button type="submit"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                        class="dropdown-item">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    <span>Xóa</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-3 d-flex  justify-content-center p-0" style="width: 20%">
                        <img src="{{ render_url_upload($vote["current"]->user->logo) }}" class="avatar-lg"
                             onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                             alt="">
                    </div>
                    <div class="col-9">
                        <a href="
                        " class="text-brown">
                            <b>{{ $vote["current"]->user->full_name  }}</b>
                        </a>
                        <div>
                    <span>
                        @php
                            $star = $vote["current"]->star;
                            $starCount = 5;
                        @endphp
                        @for($i = 1; $i <= $starCount; $i++)
                            <i class="fa fa-star {{ $i <= $star ? "active" : "text-secondary" }}"></i>
                        @endfor
                    </span> -
                            <span class="fs-13px">{{ $vote["current"]->updated_at ?? "Đang cập nhật" }}</span>
                        </div>
                        @if(!empty($vote["current"]->description))
                            <div class="collslap mt-2 d-block">
                                <p class=" break-word mw-100 "
                                   style="background:#f2f3f5;  padding: 9px 12px; border-radius: 18px;">
                                    {!! $vote["current"]->description !!}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if(count($vote["list"]) > 0)
            <p class="fw-bold fs-18px">Tất cả đánh giá</p>
            @foreach($vote["list"] as $item)
                <div class="bg-white p-3 shadow-sm mb-2">
                    <div class="row ">
                        <div class="col-3 d-flex p-0 justify-content-center" style="width: 20%">
                            <img src="{{ render_url_upload($item->user->logo) }}" class="avatar-lg"
                                 onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                 alt="">
                        </div>
                        <div class="col-9">
                            <a href="
                            " class="text-brown">
                                <b>{{ $item->user->full_name  }}</b>
                            </a>
                            <div>
                    <span>
                        @php
                            $star = $item->star;
                            $starCount = 5;
                        @endphp
                        @for($i = 1; $i <= $starCount; $i++)
                            <i class="fa fa-star {{ $i <= $star ? "active" : "text-secondary" }}"></i>
                        @endfor
                    </span> -
                                <span class="fs-13px">{{ $item->updated_at ?? "Đang cập nhật" }}</span>
                            </div>
                            @if(!empty($item->description))
                                <div class="collslap mt-2 d-block">
                                    <p class=" break-word mw-100 "
                                       style="background:#f2f3f5;  padding: 9px 12px; border-radius: 18px;">
                                        {!! $item->description !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-2">
                {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($vote["list"], $query) !!}
            </div>
        @endif
    </div>
    @if(count($vote["list"]) > 0)
        <div class="col-lg-12 mb-4">
            <div class="bg-white p-3 shadow-sm mb-2" style="margin-top: 39px">
                <h3 class="fw-bold fs-18px">Đánh giá tổng quát</h3>
                @php
                    $starCount = 5;
                @endphp
                @for($i = 1; $i <= $starCount; $i++)
                    <i class="fa fa-star {{ $i <= ($starVote ?? 0) ? "active" : "text-secondary" }}"></i>
                @endfor
                <div class="mb-3 fs-13px opacity-75">Dựa trên {{ $vote["list"]->total() }} đánh giá</div>
                @foreach($vote["overview"] as $star => $overview)
                    <div class="row mb-3">
                        <div class="col-1 d-flex">
                            <div class="w-10px">{{ $star }}</div>
                            <i class="fa fa-star ms-1 active"></i>
                        </div>
                        <div class="col-11">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar"
                                     data-bs-toggle="tooltip" data-bs-placement="top"
                                     title="{{ $overview["count"] }} đánh giá"
                                     aria-label="Default striped example" style="width: {{ $overview["percent"] }}%"
                                     aria-valuenow="10"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>


