<?php

namespace Modules\Base\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;

class FileApiController extends Controller
{
    public function upload(Request $request)
    {
        $name = "";
        if ($request->has("upload")) {
            $file = $request->upload;
            $name = FileUploaderService::getInstance()
                ->uploadOnlyFile($file)
                ->getUrlFileUpload();

            $name = $name["data"];
        }

        $editor = $request->input('CKEditorFuncNum');
        $msg = 'Image uploaded successfully';
        $name = render_url_upload($name);
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($editor, '$name', '$msg')</script>";

        @header('Content-type: text/html; charset=utf-8');
        echo  $response;
    }
}