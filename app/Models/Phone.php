<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $fillable=[
        'phone_type',
        'phone_number',
        'title'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
