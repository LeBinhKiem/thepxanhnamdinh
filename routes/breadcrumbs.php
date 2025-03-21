<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('get.home.index'));
});


Breadcrumbs::for('keyword', function (BreadcrumbTrail $trail) {
    $trail->parent("home");
    $trail->push('Từ khóa');
});

Breadcrumbs::for('product', function (BreadcrumbTrail $trail) {
    $trail->parent("home");
    $trail->push('Sản phẩm');
});

Breadcrumbs::for('accounts', function (BreadcrumbTrail $trail) {
    $trail->parent("home");
    $trail->push('Tài khoản');
});

// Tài khoản Admin

Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->parent("accounts");
    $trail->push('Admin', route("get.admin.index"));
});
Breadcrumbs::for('admin::create', function (BreadcrumbTrail $trail) {
    $trail->parent("admin");
    $trail->push('Thêm mới');
});
Breadcrumbs::for('admin::edit', function (BreadcrumbTrail $trail) {
    $trail->parent("admin");
    $trail->push('Cập nhật');
});
Breadcrumbs::for('admin::update_password', function (BreadcrumbTrail $trail) {
    $trail->parent("admin");
    $trail->push('Cập nhật');
});

Breadcrumbs::for('admin::view', function (BreadcrumbTrail $trail) {
    $trail->parent("admin");
    $trail->push('Thông tin tài khoản');
});

Breadcrumbs::for('admin::setting', function (BreadcrumbTrail $trail) {
    $trail->parent("admin");
    $trail->push('Thiết lập tài khoản');
});


Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->push('Danh mục sản phẩm', route("get.categories.index"));
});

Breadcrumbs::for('categories::create', function (BreadcrumbTrail $trail) {
    $trail->parent("categories");
    $trail->push('Cập nhật');
});
Breadcrumbs::for('categories::edit', function (BreadcrumbTrail $trail) {
    $trail->parent("categories");
    $trail->push('Cập nhật');
});

Breadcrumbs::for('blog_categories', function (BreadcrumbTrail $trail) {
    $trail->parent("keyword");
    $trail->push('Danh mục Blog', route("get.blog_categories.index"));
});

Breadcrumbs::for('blog_categories::create', function (BreadcrumbTrail $trail) {
    $trail->parent("blog_categories");
    $trail->push('Thêm mới', route("get.blog_categories.create"));
});

Breadcrumbs::for('blog_categories::edit', function (BreadcrumbTrail $trail) {
    $trail->parent("blog_categories");
    $trail->push('Cập nhật');
});

Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
    $trail->parent("product");
    $trail->push('Blog', route("get.blog.index"));
});

Breadcrumbs::for('blog::create', function (BreadcrumbTrail $trail) {
    $trail->parent("blog");
    $trail->push('Thêm mới', route("get.blog.create"));
});

Breadcrumbs::for('blog::edit', function (BreadcrumbTrail $trail) {
    $trail->parent("blog");
    $trail->push('Cập nhật');
});