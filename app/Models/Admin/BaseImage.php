<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Base;
use Illuminate\Support\Str;
use Intervention\Image\Facades\image;
use Illuminate\Support\Facades\Storage;


class BaseImage extends Model
{
	protected $fillable = ['base_image_name', 'base_id'];
    protected $primaryKey = 'base_image_id';


    public function base()
    {
        return $this->belongsTo(Base::class, 'base_id');
    }

    public static function setImage($base_image, $actual = false)
    {
        if ($base_image) {
            if ($actual) {
                Storage::disk('public')->delete("images/bases/$actual");
            }
            $imageName = Str::random(20) . '.jpg';

            $imagen = Image::make($base_image)->encode('jpg', 75);
            // $imagen->resize(65, 65, function ($constraint) {
            //     $constraint->upsize();
            // });

            Storage::disk('public')->put("images/bases/$imageName", $imagen->stream());
            return $imageName;
        } else {
            return false;
        } 
    }    
}    


