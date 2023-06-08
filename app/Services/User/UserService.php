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
use Exception;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make($attributes['password']),
        ]);

        $data['token'] = $user->createToken('user_token')->plainTextToken;
        $data['user'] = $user;
        return $data;
    }

    /**
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function login(array $attributes): array
    {
        $user = $this->user->query()->where('email', '=', $attributes['email'])->firstOrFail();

        if (!Hash::check($attributes['password'], $user->password)) {
            throw new Exception('Something Wrong in Login!!');
        }

        $data['token'] = $user->createToken('user_token')->plainTextToken;
        $data['user'] = $user;
        return $data;
    }

    /**
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function logout(array $attributes): array
    {
        $user = $this->user->query()->findOrFail($attributes['user_id']);

        $user->tokens()->delete();
        $data['message'] = "User Logout SuccessFully!";
        return $data;
    }
}
