<?php
declare(strict_types=1);

namespace App\Infrastructure\InMemory\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\Type\FileId;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * class InMemoryFileRepository
 *
 * @property array<string,\App\Domain\Models\File\File> $store store
 */
final class InMemoryFileRepository implements IFileRepository
{
    public array $store = [];

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
    public function getById(FileId $fileId): File
    {
        if (array_key_exists($fileId->value, $this->store)) {
            return $this->clone($this->store[$fileId->value]);
        } else {
            throw new RecordNotFoundException();
        }
    }

    /**
     * @inheritDoc
     */
    public function save(File $file): FileId
    {
        $this->store[$file->id->value] = $this->clone($file);

        return $file->id;
    }

    /**
     * @param \App\Domain\Models\File\File $file file
     * @return \App\Domain\Models\File\File
     */
    private function clone(File $file): File
    {
        return File::reconstruct(
            $file->id,
            $file->fileName,
            $file->fileSize,
            $file->contentType,
            $file->fileDirectory,
        );
    }
}
