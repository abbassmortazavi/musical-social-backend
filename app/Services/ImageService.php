<?php
/**
 * ImageService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from musical-social-backend
 * @version 1.0.0
 * @date 2023/06/09 16:38
 */


namespace App\Services;


use Intervention\Image\Facades\Image;

class ImageService
{
    public function updateImage($model, $request, $path, $methodType)
    {
        $image = Image::make($request->file('image'));

        if (!empty($model->image)) {
            $currentImage = public_path() . $path . $model->image;
            if (file_exists($currentImage)) {
                unlink($currentImage);
            }
        }
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $image->crop($request->width, $request->height, $request->top, $request->left);
        $name = time() . '.' . $extension;
        $image->save(public_path() . $path . $name);

        if ($methodType === "store") {
            $model->user_id = $request->get('user_id');
        }
        $model->image = $name;
        $model->save();


    }
}
