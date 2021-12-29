<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\Type\FileId;
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
}
