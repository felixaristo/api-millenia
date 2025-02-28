<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Article extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    protected $table = 'article';
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var string[]
    //  */
    protected $fillable = [
        'title',
        'image',
        'author',
        'description',
        'content',
        'is_deleted'
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
