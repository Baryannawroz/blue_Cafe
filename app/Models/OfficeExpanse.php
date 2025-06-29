<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OfficeExpanse extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
}
