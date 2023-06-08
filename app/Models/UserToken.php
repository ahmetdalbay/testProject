<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'client_id', 'access_token', 'refresh_token'];

    public function client()
    {
        return $this->hasOne(UserClient::class,'id','client_id');
    }
}
