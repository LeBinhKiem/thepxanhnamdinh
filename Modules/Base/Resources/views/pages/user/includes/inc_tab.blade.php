<style>
    .list-item {
        cursor: pointer;
        border-radius: 0.375rem;
        display: block;
        text-align: center;
        padding: 0.75rem 1rem;
        color: rgba(var(--bs-body-color-rgb), var(--bs-text-opacity));
    }

    .list-item.active {
        background-color: #472f92;
        color: white;
        font-weight: 500;
    }
    .list-item i {
        display: none;
    }
    @media screen and (max-width: 992px){
        .navbar-bottom {
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            background: white;
            display: flex;
            padding: 5px 0 !important;
            justify-content: space-between;
            border-top: 1px solid #c2bebe75;
        }
        .list-item {
            flex: 1 1;
            font-size: 0.8rem;
        }
        .list-item.active {
            background-color: white;
            color: #472f92;
        }
        .list-item i {
            display: block;
        }
    }
</style>

<div class="bg-white  ">
    <div class="navbar-bottom p-4 shadow">
        @foreach(\Modules\Accounts\Models\Enums\UserEnum::configTab as $tab)
            <a href="{{ route($tab["route"]) }}"
               class="list-item {{ \Illuminate\Support\Facades\Route::currentRouteName() == $tab["route"] ? "active" : "" }}">
                <i class="{{ $tab["icon"] }} w-100 mb-1 fs-23px"></i>
                <span class="">{{ $tab["text"] }}</span>
            </a>
        @endforeach
    </div>
</div>

