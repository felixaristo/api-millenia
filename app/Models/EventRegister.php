<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EventRegister extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    protected $table = 'event_register';    
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var string[]
    //  */
    protected $fillable = [
        'id_event',
        'firstname',
        'lastname',
        'email',
        'company',
        'role',
        'phone',
        'government_related',
        'country',
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
