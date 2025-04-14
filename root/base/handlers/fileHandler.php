<?php

namespace Root\Base\Handlers;

use Root\Base\Handlers\Request;
use Root\Base\Utilities;

class File
{
    public static function upload($requestFileName = 'file', $uploadPath = null, $alternativeName = null): array
    {
        $getFile = Request::file($requestFileName);
        if (!$getFile) {
            return ['fileName' => null, 'filePath' => null, 'fileUrl' => null];
        }
        $fileNames =   $filePaths = $fileUrls = [];
        if (!$uploadPath) {
            $uploadPath = "uploads/common";
        }
        $uploadPath = trim($uploadPath, '/') . '/';
        Utilities::makeDirectoryIfNotExists($uploadPath);
        $getBaseUrl = Request::baseUrl();
        if (is_array($getFile['name'])) { // Check if the file is an array (multiple files)
            for ($i = 0; $i < count($getFile['name']); $i++) {
                if ($getFile['error'][$i] !== UPLOAD_ERR_OK) {
                    continue;
                }
                $alternativeNewFileName = self::getFileName($alternativeName, $getFile['name'][$i]);
                $fileNames[] = $alternativeNewFileName;
                $filePaths[] = $uploadPath . $alternativeNewFileName;
                $fileUrls[] = $getBaseUrl . '/' . $uploadPath . $alternativeNewFileName;
                move_uploaded_file($getFile['tmp_name'][$i], APP_PATH . '/' . $uploadPath . $alternativeNewFileName);
            }
        } else {
            if ($getFile['error'] !== UPLOAD_ERR_OK) {
                return ['fileName' => null, 'filePath' => null, 'fileUrl' => null];
            }
            $alternativeNewFileName = self::getFileName($alternativeName, $getFile['name']);
            $fileNames[] = $alternativeNewFileName;
            $filePaths[] = $uploadPath . $alternativeNewFileName;
            $fileUrls[] = $getBaseUrl . '/' . $uploadPath . $alternativeNewFileName;
            move_uploaded_file($getFile['tmp_name'], APP_PATH . '/' . $uploadPath . $alternativeNewFileName);
        }
        return [
            'fileName' => implode(',', $fileNames),
            'filePath' => implode(',', $filePaths),
            'fileUrl' => implode(',', $fileUrls)
        ];
    }

    private static function getFileName($fileName = null, $getExtension): string
    {
        if (!$fileName) {
            return Utilities::uuid() . '.' . self::getExtension($getExtension);
        } else {
            return $fileName . '.' . self::getExtension($getExtension);
        }
    }
    public static function delete($filePath): bool
    {
        if (file_exists($filePath)) {
            return unlink($filePath);
        } else {
            return false;
        }
    }
    public static function getExtension($fileName): string
    {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }
}
