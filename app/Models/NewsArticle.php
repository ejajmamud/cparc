<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class NewsArticle extends Model {
    use HasFactory;
    protected $fillable = ['title','slug','content','image','is_published','published_at'];
    protected $casts = ['published_at' => 'datetime', 'is_published' => 'boolean'];
}