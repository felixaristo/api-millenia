<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Event extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    protected $table = 'event';    
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var string[]
    //  */
    protected $fillable = [
        'title',
        'date',
        'speaker',
        'is_deleted',
        'created_at'
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
