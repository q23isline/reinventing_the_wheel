<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

use DomainException;

/**
 * class RoleName
 */
final class RoleName
{
    private const ARROW_ROLE_NAMES = [
        'admin',
        'editor',
        'viewer',
    ];

    /**
     * @var string
     */
    private string $value;

    /**
     * constructor
     *
     * @param string $value value
     */
    public function __construct(string $value)
    {
        if (!in_array($value, self::ARROW_ROLE_NAMES, true)) {
            throw new DomainException('ロール名は admin, editor, viewer のいずれかです。');
        }

        $this->value = $value;
    }

    /**
     * Get the value of value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
