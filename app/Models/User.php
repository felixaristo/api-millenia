<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    protected $table = 'user';
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var string[]
    //  */
    protected $fillable = [
        'username'
    ];

    // /**
    //  * The attributes excluded from the model's JSON form.
    //  *
    //  * @var string[]
    //  */
    protected $hidden = [
        'password',
    ];
}
