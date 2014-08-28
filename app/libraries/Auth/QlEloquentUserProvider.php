<?php namespace Auth;

/* 修改默认Auth密码验证 */
class QlEloquentUserProvider implements EloquentUserProvider {

	public function __construct($model)
    {
        $this->model = $model;
    }

    public function validateCredentials(UserInterface $user, array $credentials)
    {
        $plain = $credentials['password'];
        $authPassword = $user->getAuthPassword();
        return $authPassword === $user->encPasswd($plain);
    }
}
