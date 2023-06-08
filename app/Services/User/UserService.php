<?php
/**
 * UserService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from musical-social-backend
 * @version 1.0.0
 * @date 2023/06/08 14:12
 */


namespace App\Services\User;

use App\Models\User;

class UserService
{
    public function __construct(protected User $user)
    {
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function register(array $attributes): array
    {
        $user = $this->user->query()->create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
        ]);

        $data['token'] = $user->createToken('user_token')->plainTextToken;
        $data['user'] = $user;
        return $data;
    }
}
