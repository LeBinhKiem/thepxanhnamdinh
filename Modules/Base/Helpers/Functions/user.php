<?php
if (!function_exists('get_admin_id')) {
    function get_admin_id()
    {
        return auth()->guard("admin")->user()->id ?? 0;
    }
}


if (!function_exists('get_admin')) {
    function get_admin()
    {
        return auth()->guard("admin")->user() ?? null;
    }
}
if (!function_exists('get_user_id')) {
    function get_user_id()
    {
        return auth()->guard("user")->user()->id ?? 0;
    }
}


if (!function_exists('get_user')) {
    function get_user()
    {
        return auth()->guard("user")->user() ?? null;
    }
}