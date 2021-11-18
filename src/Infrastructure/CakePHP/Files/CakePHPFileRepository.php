<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\Type\ContentType;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileSize;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * class CakePHPFileRepository
 */
final class CakePHPFileRepository implements IFileRepository
{
    /**
     * @inheritDoc
     */
    public function assignId(): FileId
    {
        return new FileId(Text::uuid());
    }

    /**
     * @inheritDoc
     */
    public function getById(FileId $fileId): File
    {
        $model = TableRegistry::getTableLocator()->get('Files');
        $record = $model->get($fileId->value);

        return $this->buildEntity($record->toArray());
    }

    /**
     * @inheritDoc
     */
    public function save(File $file): FileId
    {
        $model = TableRegistry::getTableLocator()->get('Files');

        $saveData = [
            'Files' => [
                'name' => $file->fileName->value,
                'size' => $file->fileSize->value,
                'content_type' => $file->contentType->value,
                'directory' => $file->fileDirectory->value,
            ],
        ];

        $entity = $model->newEmptyEntity();
        $entity = $model->patchEntity($entity, $saveData);
        $entity->id = $file->id->value;
        $saved = $model->saveOrFail($entity);

        return new FileId($saved->id);
    }

    /**
     * @param array<string,mixed> $record record
     * @return \App\Domain\Models\File\File
     */
    private function buildEntity(array $record): File
    {
        return File::reconstruct(
            new FileId($record['id']),
            new FileName($record['name']),
            new FileSize($record['size']),
            new ContentType($record['content_type']),
            new FileDirectory($record['directory']),
        );
    }
}
