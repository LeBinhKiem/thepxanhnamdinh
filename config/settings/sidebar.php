<?php
return [
    [
        "name" => "Thống kê báo cáo",
        "route" => "get.home.index",
        "icon" => "fa-solid fa-house",
    ],
    [
        "name" => "Thông tin CLB",
        "route" => "get.info.index",
        "icon" => "fa-solid fa-circle-info",
    ],
    [
        "name" => "Tài khoản",
        "route" => "",
        "icon" => "fa-solid fa-user",
        "sub" => [
            [
                "name" => "Người dùng",
                "route" => "get.user.index",
            ],
            [
                "name" => "Admin",
                "route" => "get.admin.index",
            ]
        ]
    ],
    [
        "name" => "Đội hình",
        "route" => "",
        "icon" => "fa-solid fa-people-group",
        "sub" => [
            [
                "name" => "Đội hình 1 & Trẻ",
                "route" => "get.players.index",
            ],
            [
                "name" => "Ban huấn luyện",
                "route" => "get.coaches.index",
            ],
        ]
    ],
    [
        "name" => "Sản phẩm",
        "route" => "",
        "icon" => "fa-solid fa-book",
        "sub" => [
            [
                "name" => "Danh mục",
                "route" => "get.categories.index",
            ],
            [
                "name" => "Sản phẩm",
                "route" => "get.products.index",
            ],
        ]
    ],
    [
        "name" => "Truyền thông",
        "route" => "",
        "icon" => "fa-solid fa-pager",
        "sub" => [
            [
                "name" => "Danh mục trang",
                "route" => "get.blog_categories.index",
            ],
            [
                "name" => "Blog",
                "route" => "get.blog.index",
            ],
            [
                "name" => "Media",
                "route" => "get.medias.index",
            ]
        ]
    ],
    [
        "name" => "Đơn hàng",
        "route" => "get.orders.index",
        "icon" => "fa-solid fa-cart-shopping",
    ],
];