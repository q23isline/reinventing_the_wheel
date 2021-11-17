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
 * @property-read \App\Domain\Models\File\Type\FileSize $filesize filesize
 * @property-read \App\Domain\Models\File\Type\ContentType $contentType contentType
 * @property-read \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
 */
final class File
{
    private FileId $id;
    private FileName $fileName;
    private FileSize $filesize;
    private ContentType $contentType;
    private FileDirectory $fileDirectory;

    /**
     * constructor
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @param \App\Domain\Models\File\Type\FileSize $filesize filesize
     * @param \App\Domain\Models\File\Type\ContentType $contentType contentType
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @return void
     */
    private function __construct(
        FileId $id,
        FileName $fileName,
        FileSize $filesize,
        ContentType $contentType,
        FileDirectory $fileDirectory
    ) {
        $this->id = $id;
        $this->fileName = $fileName;
        $this->filesize = $filesize;
        $this->contentType = $contentType;
        $this->fileDirectory = $fileDirectory;
    }

    /**
     * 新規作成
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @param \App\Domain\Models\File\Type\FileSize $filesize filesize
     * @param \App\Domain\Models\File\Type\ContentType $contentType contentType
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @return self
     */
    public static function create(
        FileId $id,
        FileName $fileName,
        FileSize $filesize,
        ContentType $contentType,
        FileDirectory $fileDirectory
    ): self {
        return new self(
            $id,
            $fileName,
            $filesize,
            $contentType,
            $fileDirectory,
        );
    }

    /**
     * 再構成
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileName $fileName fileName
     * @param \App\Domain\Models\File\Type\FileSize $filesize filesize
     * @param \App\Domain\Models\File\Type\ContentType $contentType contentType
     * @param \App\Domain\Models\File\Type\FileDirectory $fileDirectory fileDirectory
     * @return self
     */
    public static function reconstruct(
        FileId $id,
        FileName $fileName,
        FileSize $filesize,
        ContentType $contentType,
        FileDirectory $fileDirectory
    ): self {
        return new self(
            $id,
            $fileName,
            $filesize,
            $contentType,
            $fileDirectory,
        );
    }

    /**
     * Get the value of id
     *
     * @return \App\Domain\Models\File\Type\FileId
     */
    public function getId(): FileId
    {
        return $this->id;
    }

    /**
     * Get the value of fileName
     *
     * @return \App\Domain\Models\File\Type\FileName
     */
    public function getFileName(): FileName
    {
        return $this->fileName;
    }

    /**
     * Get the value of filesize
     *
     * @return \App\Domain\Models\File\Type\FileSize
     */
    public function getFileSize(): FileSize
    {
        return $this->filesize;
    }

    /**
     * Get the value of contentType
     *
     * @return \App\Domain\Models\File\Type\ContentType
     */
    public function getContentType(): ContentType
    {
        return $this->contentType;
    }

    /**
     * Get the value of fileDirectory
     *
     * @return \App\Domain\Models\File\Type\FileDirectory
     */
    public function getFileDirectory(): FileDirectory
    {
        return $this->fileDirectory;
    }
}
