<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ItemCategory;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'kode',
        'nama',
        'harga_beli',
        'laba',
        'supplier',
        'jenis',
        'foto',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            ItemCategory::class,
            'item_category_master_item'
        );
    }
}
