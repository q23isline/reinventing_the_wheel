<?php
declare(strict_types=1);

namespace App\Domain\Models\File;

use App\Domain\Models\File\Type\FileId;
use Laminas\Diactoros\UploadedFile;

/**
 * interface IFileStorageRepository
 */
interface IFileStorageRepository
{
    /**
     * ファイル保存ディレクトリを取得する（ユーザー用）
     *
     * @return string
     */
    public function getDirectoryForUser(): string;

    /**
     * ファイルをアップロードする
     *
     * @param \Laminas\Diactoros\UploadedFile $file file
     * @param \App\Domain\Models\File\Type\FileId $fileId fileId
     * @param string $directory directory
     * @return void
     */
    public function upload(UploadedFile $file, FileId $fileId, string $directory): void;
}
