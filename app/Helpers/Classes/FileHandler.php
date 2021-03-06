<?php

namespace App\Helpers\Classes;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Throwable;

/**
 * Class FileHandler
 * @package App\Helpers\Classes
 */
class FileHandler
{
    /**
     * @param UploadedFile|null $file
     * @param string|null $dir
     * @param string|null $fileName
     * @return string|null Stored file name, null if uploaded file is null or unable to upload
     */
    public static function storeFile(?UploadedFile $file, ?string $dir = '', ?string $fileName = ''): ?string
    {
        if (!$file) {
            return null;
        }
        $fileName = $fileName ?: md5(time()) . '.' . $file->getClientOriginalExtension();
        if ($dir) {
            $dir = $dir . "/" . date('Y/F');
            if (file_exists($dir)) {
                mkdir($dir, 0777);
            }
        }
        //TODO: add image resizer to store thumbnails
        try {
            $path = Storage::putFileAs(
                $dir, $file, $fileName
            );
        } catch (Throwable $exception) {
            return $exception;
        }

        return $path;
    }

    /**
     * @param string|null $path
     * @return bool
     */
    public static function deleteFile(?string $path): bool
    {
        if (is_null($path)) {
            return false;
        }

        try {
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            return false;
        }

        return true;
    }

    public static function uploadToCloud(UploadedFile $file)
    {
        $fileName = Uuid::uuid6() . "." . $file->getClientOriginalExtension();
        $url = "https://file.nise.gov.bd/test";
        $fileUploaded = Http::withOptions([
            'verify' => config("nise3.should_ssl_verify"),
            'debug' => config('nise3.http_debug'),
        ])
            ->timeout(60)
            ->attach("files", file_get_contents($file), $fileName)
            ->put($url)
            ->throw(static function (Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                CustomExceptionHandler::customHttpResponseMessage($httpResponse->body());
            })
            ->json();
        return $fileUploaded['status'] ? $fileUploaded['url'] : null;
    }
}
