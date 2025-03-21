<?php

namespace Modules\Base\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    protected $table = "votes";

    public function user()
    {
        return $this->hasOne(User::class, "id","user_id");
    }
}
