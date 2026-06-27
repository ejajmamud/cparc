<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GalleryAlbum extends Model {
    use HasFactory;
    protected $fillable = ['name','slug','cover_image','is_published'];
    protected $casts = ['is_published' => 'boolean'];
    public function photos() { return $this->hasMany(GalleryPhoto::class); }
}