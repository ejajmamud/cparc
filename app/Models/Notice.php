<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notice extends Model {
    use HasFactory;
    protected $fillable = ['title','slug','content','type','attachment','is_new','is_published','published_at'];
    protected $casts = ['published_at' => 'datetime', 'is_new' => 'boolean', 'is_published' => 'boolean'];
}