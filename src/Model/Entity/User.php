<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string $first_name
 * @property string $last_name
 * @property string $first_name_kana
 * @property string $last_name_kana
 * @property string $mail_address
 * @property string $sex
 * @property \Cake\I18n\FrozenDate|null $birth_day
 * @property string|null $cell_phone_number
 * @property string|null $remarks
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity
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
        'username' => true,
        'password' => true,
        'role' => true,
        'first_name' => true,
        'last_name' => true,
        'first_name_kana' => true,
        'last_name_kana' => true,
        'mail_address' => true,
        'sex' => true,
        'birth_day' => true,
        'cell_phone_number' => true,
        'remarks' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var string[]
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * パスワードを生成する
     *
     * @param string $password パスワード
     * @return string|false|void ハッシュ化されたパスワード
     */
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
