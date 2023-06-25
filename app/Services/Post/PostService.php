<?php
/**
 * PostService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from musical-social-backend
 * @version 1.0.0
 * @date 2023/06/25 18:21
 */


namespace App\Services\Post;

use App\Models\Post;
use App\Models\Song;
use App\Services\ImageService;
use App\Services\User\UserService;
use Exception;
use Illuminate\Support\Facades\Log;

class PostService
{
    public function __construct(protected Post $post)
    {
    }

    /**
     * @param int $id
     * @return object
     */
    public function show(int $id): object
    {
        return $this->post->query()->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool|int
     * @throws Exception
     */
    public function update(array $attributes, int $id): bool|int
    {
        $user = $this->user->query()->findOrFail($id);
        $image = "";
        if (request()->hasFile('image')) {
            app(ImageService::class)->updateImage($user, request(), '/images/users/', 'update');
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

    /**
     * @throws Exception
     */
    public function store(array $attributes): void
    {
        $user = app(UserService::class)->show($attributes['user_id']);

        $file = $attributes['image'];
        if (empty($file)) {
            throw new Exception('No File Uploaded!!');
        }

        if (request()->hasFile('image')) {
            $image = app(ImageService::class)->updateImage($user, request(), '/posts/', 'store');
        }

        $post = $file->getClientOriginalName();
        $file->move('posts/' . $user->id, $post);
        $this->post->query()->create([
            'user_id' => $user->id,
            'title' => $attributes['title'] ?? null,
            'location' => $attributes['location'] ?? null,
            'description' => $attributes['description'] ?? null,
            'image' => $image ?? null,
        ]);
    }

    public function destroy(int $id, int $userId): void
    {
        $post = $this->find($id);
        $currentSong = public_path() . "/posts/" . $userId . "/" . $post->post;
        if (file_exists($currentSong)) {
            unlink($currentSong);
        }
        $post->delete();
    }

    /**
     * @param int $id
     * @return object
     */
    public function find(int $id): object
    {
        return $this->post->query()->findOrFail($id);
    }
}
