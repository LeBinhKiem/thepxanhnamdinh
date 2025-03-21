<?php
if (!function_exists('render_url_upload')) {
    function render_url_upload($url)
    {
        $url = \Dinhthang\FileUploader\Services\FileUploaderService::getInstance()->renderUrl($url);

        return $url;
    }
}