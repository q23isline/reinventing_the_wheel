<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserAddUseCase
 */
class UserAddUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\User\IUserRepository $userRepository userRepository
     * @param \App\Domain\Services\UserService $userService userService
     */
    public function __construct(
        private IUserRepository $userRepository,
        private UserService $userService
    ) {
    }

    /**
     * ユーザーを新規追加する
     *
     * @param \App\UseCase\Users\UserAddCommand $command command
     * @return \App\Domain\Models\User\Type\UserId
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function handle(UserAddCommand $command): UserId
    {
        $data = User::create(
            // TODO: 採番処理を UserId ドメインの中でやりたい
            $this->userRepository->assignId(),
            new MailAddress($command->mailAddress),
            new Password($command->password),
            new RoleName($command->roleName),
        );

        if ($this->userService->isExists($data)) {
            throw new ValidateException([new ExceptionItem('mailAddress', 'メールアドレスは既に存在しています。')]);
        }

        return $this->userRepository->save($data);
    }
}
