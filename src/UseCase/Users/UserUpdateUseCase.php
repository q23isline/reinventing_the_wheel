<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserUpdateUseCase
 */
final class UserUpdateUseCase
{
    /**
     * @var \App\Domain\Models\User\IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * @var \App\Domain\Services\UserService
     */
    private UserService $userService;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\IUserRepository $userRepository userRepository
     * @param \App\Domain\Services\UserService $userService userService
     */
    public function __construct(IUserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * ユーザーを更新する（キーのある項目のみ）
     *
     * @param \App\UseCase\Users\UserUpdateCommand $command command
     * @return \App\Domain\Models\User\Type\UserId
     */
    public function handle(UserUpdateCommand $command): UserId
    {
        $loginId = is_null($command->getLoginId()) ? null : new LoginId($command->getLoginId());
        $password = is_null($command->getPassword()) ? null : new Password($command->getPassword());
        $roleName = is_null($command->getRoleName()) ? null : new RoleName($command->getRoleName());
        $firstName = is_null($command->getFirstName()) ? null : new FirstName($command->getFirstName());
        $lastName = is_null($command->getLastName()) ? null : new LastName($command->getLastName());

        $data = new User(
            new UserId($command->getUserId()),
            $loginId,
            $password,
            $roleName,
            $firstName,
            $lastName,
            null,
            null
        );

        if (!is_null($loginId) && $this->userService->isExists($data)) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは既に存在しています。')]);
        }

        return $this->userRepository->update($data);
    }
}
