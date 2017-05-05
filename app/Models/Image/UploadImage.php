<?php

namespace DropItems\Models\Image;

use Illuminate\Http\Request;
use DropItems\Models\Contructs\Image\UploadImageInterface;

class UploadImage implements UploadImageInterface
{
    /**
     * 画像を保存する
     *
     * @param $path string ディレクトリパス
     * @param $image string 画像
     * @return array|
     */
    public function saveImages($path, $image)
    {
        // 拡張子を取得
        $ext = image_type_to_extension($image);

        // ファイル名
        $name = date('Y-m-d H:i:s').str_random(16);

        // 保存

    }

    /**
     * 画像を削除する
     *
     * @param $path string ディレクトリパス
     * @param $image_id string 画像ID
     * @return boolean
     */
    public function deleteImage($path, $image_id)
    {
        // TODO: Implement deleteImage() method.
    }
}