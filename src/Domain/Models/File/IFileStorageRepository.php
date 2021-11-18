<?php
declare(strict_types=1);

namespace App\Domain\Models\File;

use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileUrl;
use Laminas\Diactoros\UploadedFile;

/**
 * interface IFileStorageRepository
 */
interface IFileStorageRepository
{
    /**
     * ファイル保存 URL を取得する
     *
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @param \App\Domain\Models\File\Type\FileId $fileId fileId
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @return \App\Domain\Models\File\Type\FileUrl
     */
    public function getUrl(FileDirectory $fileDirectory, FileId $fileId, FileName $fileName): FileUrl;

    /**
     * ファイル保存ディレクトリを取得する（ユーザー用）
     *
     * @param \App\Domain\Models\File\Type\FileId $fileId fileId
     * @return string
     */
    public function getDirectoryForUser(FileId $fileId): string;

    /**
     * ファイルをアップロードする
     *
     * @param \Laminas\Diactoros\UploadedFile $file file
     * @param string $directory directory
     * @return void
     */
    public function upload(UploadedFile $file, string $directory): void;
}
