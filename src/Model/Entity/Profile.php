<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Profile Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $first_name_kana
 * @property string $last_name_kana
 * @property string $sex
 * @property \Cake\I18n\Date|null $birth_day
 * @property string|null $cell_phone_number
 * @property string|null $remarks
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ProfileFile[] $profile_files
 */
class Profile extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'first_name' => true,
        'last_name' => true,
        'first_name_kana' => true,
        'last_name_kana' => true,
        'sex' => true,
        'birth_day' => true,
        'cell_phone_number' => true,
        'remarks' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'profile_files' => true,
    ];
}
