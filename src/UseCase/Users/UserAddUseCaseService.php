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
use Exception;

/**
 * class UserAddUseCaseService
 */
final class UserAddUseCaseService
{
    /**
     * @var IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * constructor
     *
     * @param IUserRepository $userRepository userRepository
     * @param UserService $userService userService
     */
    public function __construct(IUserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * ユーザーを新規追加する
     *
     * @param UserAddCommand $command command
     * @return UserId
     */
    public function handle(UserAddCommand $command): UserId
    {
        // TODO: 新規登録には不要な ID などを null で初期化する必要があるのを何とかしたい
        $data = new User(
            null,
            new LoginId($command->getLoginId()),
            new Password($command->getPassword()),
            new RoleName($command->getRoleName()),
            new FirstName($command->getFirstName()),
            new LastName($command->getLastName()),
            null,
            null
        );

        if ($this->userService->isExists($data)) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは既に存在しています。')]);
        }

        return $this->userRepository->save($data);
    }
}
