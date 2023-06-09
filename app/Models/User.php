<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'Prenom',
        'email',
        'password',
        'Tel',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getName($user_id)
    {
        return DB::selectOne('select name,Prenom from users u
        Join Ticket t on u.id = t.User_id  where t.User_id = ?;', [$user_id]);
    }
    public function isAdmin()
    {
        $result = DB::selectOne('select Label
        FROM `Role` r
        inner join UserRole ur on r.Id = ur.IdRole
        inner join users u on ur.IdUser = u.id
        where u.id = ?;',
            [auth()->user()->id]
        );
        if (
            $result->Label == 'Administrateur'
        ) {
            return true;
        } else {
            return false;
        }

    }
}
