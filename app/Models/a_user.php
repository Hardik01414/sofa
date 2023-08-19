<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class a_user extends Model
{
    use HasFactory;

    protected $table = "a_users";

    protected $primaryKey = "id";

    protected $fillable = ['uname','password'];
}