# How to use Package

1. Upload
```
#Upload only File

$file = FileUploaderService::getInstance()
->uploadOnlyFile($request->file)

#Upload multi file
$file = FileUploaderService::getInstance()
->uploadMultiFile($request->file)
```

2. Upload function Support

```
$file = FileUploaderService::getInstance()
->uploadOnlyFile($request->file)
->setMaxSize(1000)
->setTypeAccept(["png"])
->getNameFile()
```

- setMaxSize : `Max size file can be uploaded`

- setTypeAccept : `Extension file can be uploaded`

- getNameFile : `get name file after upload`

Other you can check error after upload file
```
$errors = $file->getError();
```

