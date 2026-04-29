<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $user_id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property int $user_type
 * @property varchar $reset_id
 * @property varchar $time_limit
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
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'email' => true,
        'phone' => true,
        'password' => true,
        'first_name' => true,
        'last_name' => true,
        'user_type' => true,
        'user_type_name' => true,
        'confirm_password' => true,
        'reset_id' => true,
        'time_limit' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * password setter from cakephp cookbook
     * @param string $password
     * @return string|null
     */
    protected function _setPassword(string $password): ?string
    {
        if (mb_strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return null;
    }

    /**
     * virtual entity to get the name of user_type
     * Output : user type name
     * */
    protected function _getUserTypeName() : string
    {
        if (isset($this->role)) {
            return empty($this->role->name) ? 'Invalid user type' : $this->role->name;
        }
        return 'No Role Assigned';
    }

    protected function _getFullName() : string
    {
        return ($this->first_name . ' ' . $this->last_name);
    }
}
