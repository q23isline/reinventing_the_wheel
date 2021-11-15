<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property string $id
 * @property string $name
 * @property int $size
 * @property string $content_type
 * @property string $directory
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class File extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string,bool>
     */
    protected $_accessible = [
        'name' => true,
        'size' => true,
        'content_type' => true,
        'directory' => true,
        'created' => true,
        'modified' => true,
    ];
}
