<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Banner extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    protected $table = 'banner';
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var string[]
    //  */
    protected $fillable = [
        'image',
        'banner',
    ];

    // /**
    //  * The attributes excluded from the model's JSON form.
    //  *
    //  * @var string[]
    //  */
    // protected $hidden = [
    //     'password',
    // ];
}
