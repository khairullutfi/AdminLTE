<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
     use SoftDeletes;

     protected $fillable = [
      'name', 'initial', 'code',  'slug'
  ];

    protected $hidden = [

    ];


      public function attachment(){
        return $this->hasMany(Attachment::class, 'id_fitur', 'id');
    }
}
    