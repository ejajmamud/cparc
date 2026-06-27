<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Member extends Model {
    use HasFactory;
    protected $fillable = ['name','name_bn','designation','designation_bn','photo','phone','email','type','sort_order','is_published'];
    protected $casts = ['is_published' => 'boolean'];
}