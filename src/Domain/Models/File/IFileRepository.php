<?php
declare(strict_types=1);

namespace App\Domain\Models\File;

use App\Domain\Models\File\Type\FileId;

/**
 * interface IFileRepository
 */
interface IFileRepository
{
    /**
     * 採番を取得
     *
     * @return \App\Domain\Models\File\Type\FileId
     */
    public function assignId(): FileId;

    /**
     * 保存
     *
     * @param \App\Domain\Models\File\File $file file
     * @return \App\Domain\Models\File\Type\FileId
     */
    public function save(File $file): FileId;
}
