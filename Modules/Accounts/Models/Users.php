<?php

namespace Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    public function reasonLock()
    {
        return $this->hasOne(ReasonsLockUser::class,"user_id", "id")->orderBy("created_at","desc");
    }
}