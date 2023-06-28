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
use Illuminate\Contracts\Pagination\Paginator;
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
        return $this->post->query()->with('user')->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool|int
     * @throws Exception
     */
    public function update(array $attributes, int $id): bool|int
    {
        $post = $this->post->query()->findOrFail($id);

        if (request()->hasFile('image')) {
            $image = app(ImageService::class)->updateImage($post->user_id, request(), '/posts/', 'store');
        } else {
            $image = $post->image;
        }


        return $post->update([
            'title' => $attributes['title'] ?? $post->title,
            'location' => $attributes['location'] ?? $post->location,
            'description' => $attributes['description'] ?? $post->description,
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

    public function destroy(int $id): void
    {
        $post = $this->find($id);
        $currentPost = public_path() . "/posts/" . $post->image;
        if (file_exists($currentPost)) {
            unlink($currentPost);
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

    /**
     * @param int $id
     * @return object
     */
    public function postByUser(int $id): object
    {
        $user = app(UserService::class)->show($id);

        return $user->load('posts');
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $data['posts'] = $this->post->query()
            ->with('user')
            ->orderByDesc('updated_at')
            ->simplePaginate(1);
        $data['pageCount'] = count(Post::all());
        return $data;
    }
}
