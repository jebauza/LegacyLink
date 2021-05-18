<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class UploadFile
{
    public static function upload($file, $path, $isBase64 = false, $disk = 'public')
    {
        $file_name = uniqid() . '.';
        $file_path = null;

        if ($isBase64) {
            $file_name = $file_name . self::getExtensionBase64($file);
            $file_path = $path . '/' . $file_name;
            $upload = Storage::disk($disk)->put($file_path, self::getFileFromBase64($file));
            if (!$upload) {
                $file_path = null;
            }
        } else {
            $file_name = $file_name . $file->getClientOriginalExtension();
            $file_path = Storage::disk($disk)->putFileAs($path, $file, $file_name);
        }

        return $file_path;
    }

    /*
     * Delete file
     */
    public static function delete($path, $disk = 'public')
    {
        $exist_file = Storage::disk($disk)->exists($path);

        if($exist_file){
            Storage::disk($disk)->delete($path);
        }
    }

    /*
     * build img from base64
     */
    public static function getFileFromBase64($base64)
    {
        $explode = explode(',', $base64);

        if(isset($explode[1])){
            return base64_decode($explode[1]);
        }

        return null;
    }

    /*
     * Get original extension from base64
     */
    public static function getExtensionBase64($base64)
    {
        $extension = explode('/', $base64);
        $extension = explode(';', $extension[1]);
        $extension = trim($extension[0]);

        return $extension;
    }

    public static function getTypeFileByExt($ext) {

        if ($ext) {
            $videos = ['h264','mpeg','asf','flv','mp4','m3u8','3gp','qt','avi','wmv','mkv'];
            $images = ['jpeg','jpg','gif','png','svg','bmp','tiff','psd'];

            if (in_array(strtolower($ext), $videos)) {
                return 'video';
            } else if (in_array(strtolower($ext), $images)) {
                return 'image';
            }
        }

        return null;
    }
}
