<?php

namespace Modules\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Modules\Products\Models\BLogs;

class Comment extends Model
{
    protected $table = "comments";

    protected $fillable = [
        'comment','user_id','blog_id'
    ];
    public function user()
    {
        return $this->hasOne(User::class, "id","user_id");
    }
    public function blog()
    {
        return $this->hasOne(BLogs::class, "id","blog_id");
    }
}
