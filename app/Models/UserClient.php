<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class UserClient extends Model
{
    use HasFactory, SoftDeletes, AsSource;

    protected $fillable = ['user_id', 'name', 'base_uri', 'client_id', 'client_secret'];
}
