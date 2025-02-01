<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_apoteker';
    protected $keyType = 'char';
    public $incrementing = false;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
        return 'id_apoteker';
    }

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
