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
use App\Services\ImageService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

//ta 23
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

    /**
     * @param int $id
     * @return object
     */
    public function show(int $id): object
    {
        return $this->user->query()->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool|int
     * @throws Exception
     */
    public function update(array $attributes, int $id): bool|int
    {
        $user = $this->user->query()->whereId($id)->first();
        if (request()->hasFile('image')) {
            $image = app(ImageService::class)->updateImage($user, request(), '/images/users/', 'update');
        } else {
            $image = $user->image;
        }
        return $user->update([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'location' => $attributes['location'],
            'description' => $attributes['description'],
            'image' => $image,
        ]);
    }
}
