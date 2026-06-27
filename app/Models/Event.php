<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Event extends Model {
    use HasFactory;
    protected $fillable = ['title','slug','description','image','event_date','time','venue','is_published'];
    protected $casts = ['event_date' => 'date', 'is_published' => 'boolean'];
}