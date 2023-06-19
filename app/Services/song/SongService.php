<?php
/**
 * SongService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from musical-social-backend
 * @version 1.0.0
 * @date 2023/06/10 20:05
 */


namespace App\Services\song;

use App\Models\Song;
use App\Services\User\UserService;

class SongService
{
    public function __construct(protected Song $song)
    {
    }

    /**
     * @param int $id
     * @return object
     */
    public function show(int $id): object
    {
        return $this->song->query()->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool|int
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
     * @throws \Exception
     */
    public function store(array $attributes)
    {
        $file = $attributes['file'];
        if (empty($file)) {
            throw new \Exception('No Song Uploaded!!');
        }


        $user = app(UserService::class)->show($attributes['user_id']);
        $song = $file->getClientOriginalName();
        $file->move('songs/' . $user->id . $song);
        $this->song->query()->create([
            'user_id' => $user->id,
            'title' => $attributes['title'],
            'song' => $song,
        ]);
    }

    public function destroy(int $id, int $userId)
    {
        $song = $this->find($id);
        $currentSong = public_path() . "/songs/" . $userId . "/" . $song->song;
        if (file_exists($currentSong)) {
            unlink($currentSong);
        }
        $song->delete();
    }

    /**
     * @param int $id
     * @return object
     */
    public function find(int $id): object
    {
        return $this->song->query()->firstOrFail($id);
    }
}
