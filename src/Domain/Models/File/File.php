<?php
declare(strict_types=1);

namespace App\Domain\Models\File;

use App\Domain\Models\File\Type\ContentType;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileSize;

/**
 * class File
 *
 * @property-read \App\Domain\Models\File\Type\FileId $id id
 * @property-read \App\Domain\Models\File\Type\FileName $fileName fileName
 * @property-read \App\Domain\Models\File\Type\FileSize $fileSize fileSize
 * @property-read \App\Domain\Models\File\Type\ContentType $contentType contentType
 * @property-read \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
 */
final class File
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @param \App\Domain\Models\File\Type\FileSize $fileSize fileSize
     * @param \App\Domain\Models\File\Type\ContentType $contentType contentType
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @return void
     */
    private function __construct(
        public readonly FileId $id,
        public readonly FileName $fileName,
        public readonly FileSize $fileSize,
        public readonly ContentType $contentType,
        public readonly FileDirectory $fileDirectory
    ) {
    }

    /**
     * 新規作成
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @param \App\Domain\Models\File\Type\FileSize $fileSize fileSize
     * @param \App\Domain\Models\File\Type\ContentType $contentType contentType
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @return self
     */
    public static function create(
        FileId $id,
        FileName $fileName,
        FileSize $fileSize,
        ContentType $contentType,
        FileDirectory $fileDirectory
    ): self {
        return new self(
            $id,
            $fileName,
            $fileSize,
            $contentType,
            $fileDirectory,
        );
    }

    /**
     * 再構成
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @param \App\Domain\Models\File\Type\FileSize $fileSize fileSize
     * @param \App\Domain\Models\File\Type\ContentType $contentType contentType
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @return self
     */
    public static function reconstruct(
        FileId $id,
        FileName $fileName,
        FileSize $fileSize,
        ContentType $contentType,
        FileDirectory $fileDirectory
    ): self {
        return new self(
            $id,
            $fileName,
            $fileSize,
            $contentType,
            $fileDirectory,
        );
    }
}
