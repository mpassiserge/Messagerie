<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messagerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'from_id',
        'to_id',
        'created_at',
        'read_at'
    ];

    public $timestamps = false;

    protected $date = ['created_at','read_at'];

    public function from(){
        return $this->belongsTo(User::class , 'from_id');
    }
}
