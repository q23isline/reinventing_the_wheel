<?php
declare(strict_types=1);

namespace App\Infrastructure\InMemory\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\Type\FileId;

/**
 * class InMemoryFileRepository
 */
final class InMemoryFileRepository implements IFileRepository
{
    /**
     * @var array<string,\App\Domain\Models\File\File>
     */
    public $store = [];

    /**
     * @inheritDoc
     */
    public function assignId(): FileId
    {
        $uuid = (string)mt_rand(0, 99999999) . '-3882-42dd-9ab2-485e8e579a8e';

        return new FileId($uuid);
    }

    /**
     * @inheritDoc
     */
    public function save(File $file): FileId
    {
        $this->store[$file->getId()->getValue()] = $this->clone($file);

        return $file->getId();
    }

    /**
     * @param \App\Domain\Models\File\File $file file
     * @return \App\Domain\Models\File\File
     */
    private function clone(File $file): File
    {
        return File::reconstruct(
            $file->getId(),
            $file->getFileName(),
            $file->getFileSize(),
            $file->getContentType(),
            $file->getFileDirectory(),
        );
    }
}
