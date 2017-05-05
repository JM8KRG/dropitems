<?php

namespace DropItems\Models\Contructs\Image;

use Illuminate\Http\Request;

/**
 * Interface UploadImageInterface
 * @package DropItems\Models\Contructs\Image
 */

interface UploadImageInterface
{
    /**
     * 画像を保存する
     *
     * @param $path string ディレクトリパス
     * @param $image string 画像
     * @return array|null
     */
    public function saveImages($path, $image);

    /**
     * 画像を削除する
     *
     * @param $path string ディレクトリパス
     * @param $image_id string 画像ID
     * @return boolean
     */
    public function deleteImage($path, $image_id);
}