<?php

namespace App\Models;

use Api\Admin\Models\Role;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed password
 * @property Role[] roles
 */
class User extends Authenticatable implements Transformable, JWTSubject
{
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * A model may have multiple roles.
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(
            Role::class,
            'model',
            config('permission.table_names.model_has_roles'),
            'model_id',
            'role_id'
        );
    }

    /**
     * @return array
     */
    public function transform()
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
        ];
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
           'data'=>[
               'role'=>$this->roles->toArray(),
           ]
        ];
    }
}
