<?php
/**
 * YoutupService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from musical-social-backend
 * @version 1.0.0
 * @date 2023/06/23 18:51
 */


namespace App\Services\Youtup;

use App\Models\Youtup;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class YoutupService
{
    public function __construct(protected Youtup $youtup)
    {
    }

    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public function store(array $attributes): Model|Builder
    {
        return $this->youtup->query()->create([
            'user_id' => $attributes['user_id'],
            'title' => $attributes['title'],
            'url' => "https://www.youtube.com/embed" .'/'.'/'. $attributes['url']."?autoplay=0",
        ]);
    }

    /**
     * @param int $userId
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function show(int $userId): Model|Collection|Builder|array|null
    {
        $user = app(UserService::class)->show($userId);
        return $user->videos;
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     */
    public function destroy(int $id): mixed
    {
        return $this->youtup->query()->findOrFail($id)->delete();
    }
}
