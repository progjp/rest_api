<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['requests_from', 'requests_to', 'updated_at', 'created_at'];

    /**
     * Friends relation.
     *
     * @return \Jenssegers\Mongodb\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany(static::class, null, 'friend_ids', 'friend_ids');
    }

    /**
     * Requests relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function requestsFrom()
    {
        return $this->belongsToMany(static::class, null, 'requests_to', 'requests_from');
    }

    /**
     * Get friends of friends.
     *
     * @param $level
     * @return mixed
     */
    public function friendsOfFriends($level = 1)
    {
        $ids = array_diff(
            array_unique(
                array_merge(
                    $this->friend_ids ? $this->friend_ids : [],
                    $this->getTreeFriends(
                        $this->friends()->get(['friend_ids'])->pluck('friend_ids')->flatten()->toArray(),
                        $level
                    )
                )
            ),
            [$this->id]
        );

        return static::find($ids);
    }

    /**
     * Get nested friends.
     *
     * @param $ids
     * @param $level
     * @return array
     */
    private function getTreeFriends($ids, $level)
    {
        if (--$level) {
            $ids = array_merge(
                $ids,
                $this->getTreeFriends(static::find($ids)->pluck('friend_ids')->flatten()->toArray(), $level)
            );
        }

        return $ids;
    }
}
