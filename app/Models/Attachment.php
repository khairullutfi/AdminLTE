<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
     use SoftDeletes;

    protected $table = "attachment";

     protected $fillable = [
      'id_fitur', 'ref_id', 'filename',  'photo', 'slug'
  ];

    protected $hidden = [

    ];

   public function attachment(){
        return $this->hasMany(Company::class, 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'id_fitur', 'id');
    }

       public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'id_fitur', 'id');
    }
    
}
