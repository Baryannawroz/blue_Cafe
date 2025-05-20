<?php

namespace BinaryCastle\Boilerplate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function sideNav()
    {
        return $this->hasOne(SideNavMenu::class);
    }

    public static function getSortableColumns(): array
    {
        return self::getSearchableColumns();
    }

    public static function getSearchableColumns(): array
    {
        return ['name', 'guard_name'];
    }
}
