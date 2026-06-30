<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GalleryPhoto extends Model {
    use HasFactory;
    protected $fillable = ['gallery_album_id','path','type','thumbnail','caption','sort_order','is_published'];
    protected $casts = ['is_published' => 'boolean'];
    public function album() { return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id'); }
}