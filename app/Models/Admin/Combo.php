<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ComboImage;
use App\Models\Admin\ComboType;
use App\Models\Admin\Base;
use App\Models\Admin\Product;

class Combo extends Model
{
	protected $fillable = ['combo_name', 'combo_type_id', 'base_id', 'combo_description', 'combo_price', 'combo_state'];
    protected $primaryKey = 'combo_id';

    public function comboImages()
    {
        return $this->hasMany(ComboImage::class, 'combo_id');
    }

    public function comboType()
    {
        return $this->belongsTo(ComboType::class, 'combo_type_id');
    }

    public function base()
    {
        return $this->belongsTo(Base::class, 'base_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'combo_products', 'combo_id', 'product_id' )->withPivot('units');
    }

}
