<?php

namespace Dinhthang\FileUploader\Services;

use Dinhthang\FileUploader\Enums\FolderEnum;
use Dinhthang\FileUploader\Enums\UploadFileErrorEnum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploaderService
{
    protected static $instance = null;

    private $nameFile = [];
    private $urlFile = [];
    private $maxSize;
    private $folder;
    private $extension;
    private $errors = [];

    private $FILESYSTEM_DRIVER;

    public function __construct()
    {
        $this->folder = FolderEnum::USER;
        $this->FILESYSTEM_DRIVER = env("FILESYSTEM_DRIVER", "local");
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new FileUploaderService();
        }

        return self::$instance;
    }


    public function setMaxSize(int $maxSize)
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    public function setFolder(string $folder)
    {
        $this->folder = $folder;

        return $this;
    }

    public function setExtension(array $extension)
    {
        $this->extension = $extension;
        return $this;
    }

    public function getNameFile()
    {
        if (sizeof($this->nameFile) == 1) {
            return $this->nameFile[0];
        }

        return $this->nameFile ?? [];
    }

    public function getUrlFileUpload()
    {
        if (sizeof($this->urlFile) <= 1) {
            $url = $this->urlFile[0] ?? "";
        } else {
            $url = $this->urlFile ?? [];
        }

        $data = [
            "errors" => $this->getError(),
            "data" => $url
        ];

        $this->urlFile = [];
        return $data;
    }

    public function getError()
    {
        return $this->errors ?? [];
    }

    public function uploadOnlyFile($file)
    {

        if (!isset($file) || empty($file)) {
            $this->errors[] = UploadFileErrorEnum::FILE_NOT_EXIST;

            return $this;
        }

        $fileSize = (int)$file->getSize();

        if ($this->maxSize && $this->maxSize * 1000 < $fileSize) {
            $this->errors[] = UploadFileErrorEnum::FILE_MAX_SIZE . number_format($this->maxSize) . " KB";

            return $this;
        }

        $extension = $file->extension();
        if ($this->extension && !in_array($extension, $this->extension)) {

            $this->errors[] = UploadFileErrorEnum::FILE_EXTENSIION . "[ " . implode(",", $this->extension) . " ]";

            return $this;
        }
        try {
            $nameTemp = explode( ".", $file->getClientOriginalName());
            $name = ($nameTemp[0] ?? "")."-".time() . '.' . $file->extension();
            $this->nameFile[] = $name;

            $name = "uploads/". $name;
            $path = "public/" . $name;

            Storage::disk($this->FILESYSTEM_DRIVER)->put($path, file_get_contents($file));

            $this->urlFile[] = $name;

        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }


        return $this;
    }

    public function uploadMultiFile($files)
    {
        if (!$files) {
            $this->errors[] = UploadFileErrorEnum::FILE_NOT_EXIST;
            return $this;
        }

        foreach ($files as $file) {
            $this->uploadOnlyFile($file);
        }
        return $this;
    }

    public function removeFile($url)
    {
        try {
            if (Storage::disk($this->FILESYSTEM_DRIVER)->exists($url)) {
                Storage::disk($this->FILESYSTEM_DRIVER)->url($url);
            }
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        return $this;
    }

    public function download($path, $nameFile = "tglearning")
    {
        try {
            $size = Storage::disk($this->FILESYSTEM_DRIVER)->size("public/".$path);
            $fileUrl = Storage::disk($this->FILESYSTEM_DRIVER)->temporaryUrl("public/".$path, now()->addMinutes(3));

            $headers = [
                'Content-Type' => 'audio/wav',
                'Content-Length' => $size,
            ];
            $filename = Str::slug($nameFile).".pdf";

            return response()->streamDownload(function () use ($fileUrl, $filename, $size) {
                if (! ($stream = fopen($fileUrl, 'r'))) {
                    throw new \Exception("'Could not open stream for reading file: ['.$filename.']'");
                }

                while (! feof($stream)) {
                    echo fread($stream, 1024);
                }

                fclose($stream);
            }, $filename, $headers);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function renderUrl($url)
    {
        if (!str_contains($url, "uploads/")) {
            return $url;
        }

        return Storage::disk($this->FILESYSTEM_DRIVER)->url("public/".$url);
    }
}
