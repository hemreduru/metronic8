<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'parent_id',
        'description',
        'description_tr',
        'description_en',
        'sort_order',
        'menu_icon',
        'menu_url',
        'is_menu_item',
        'menu_group',
        'menu_order',
    ];

    protected $casts = [
        'is_menu_item' => 'boolean',
    ];

    /**
     * Parent permission relationship
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Child permissions relationship
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get all descendants (recursive children)
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors (recursive parents)
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Check if this permission is root (has no parent)
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if this permission is leaf (has no children)
     */
    public function isLeaf(): bool
    {
        return $this->children()->count() === 0;
    }

    /**
     * Get tree structure starting from root permissions
     */
    public static function getTree()
    {
        return self::whereNull('parent_id')
            ->with('descendants')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get flat list with indentation for dropdowns
     */
    public static function getFlatList($parent = null, $prefix = '')
    {
        $permissions = collect();

        $query = $parent ? $parent->children() : self::whereNull('parent_id');
        $items = $query->orderBy('sort_order')->get();

        foreach ($items as $permission) {
            $permission->display_name = $prefix . $permission->name;
            $permissions->push($permission);

            if ($permission->children()->count() > 0) {
                $permissions = $permissions->merge(
                    self::getFlatList($permission, $prefix . '── ')
                );
            }
        }

        return $permissions;
    }

    /**
     * Get localized description
     */
    public function getLocalizedDescription($locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        $column = 'description_' . $locale;

        if ($this->{$column}) {
            return $this->{$column};
        }

        // Fallback to general description or default language
        return $this->description ?: $this->description_tr ?: $this->description_en ?: $this->name;
    }

    /**
     * Set localized descriptions
     */
    public function setLocalizedDescriptions(array $descriptions)
    {
        foreach ($descriptions as $locale => $description) {
            $column = 'description_' . $locale;
            if (in_array($column, $this->fillable)) {
                $this->{$column} = $description;
            }
        }
    }

    /**
     * Get menu items that user has permission for
     */
    public static function getMenuItems($userPermissions = null)
    {
        $userPermissions = $userPermissions ?: collect();

        // Get all menu items with their children
        $menuItems = self::where('is_menu_item', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('is_menu_item', true)->orderBy('menu_order');
            }])
            ->orderBy('menu_order')
            ->get();

        // Filter based on user permissions
        return $menuItems->filter(function ($item) use ($userPermissions) {
            // Check if user has permission for this menu item or any of its children
            if ($userPermissions->contains($item->name)) {
                return true;
            }

            // Check children permissions
            foreach ($item->children as $child) {
                if ($userPermissions->contains($child->name)) {
                    return true;
                }
            }

            return false;
        })->map(function ($item) use ($userPermissions) {
            // Filter children based on permissions
            $item->children = $item->children->filter(function ($child) use ($userPermissions) {
                return $userPermissions->contains($child->name);
            });

            return $item;
        });
    }

    /**
     * Get menu URL with proper route handling
     */
    public function getMenuUrlAttribute($value)
    {
        if (!$value) {
            return '#';
        }

        // If it's already a full URL, return as is
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // If it's a route name, generate the route
        if (str_contains($value, '.')) {
            try {
                return route($value);
            } catch (\Exception $e) {
                return '#';
            }
        }

        // Otherwise, treat as path
        return url($value);
    }

    /**
     * Check if this permission should be shown in menu
     */
    public function isMenuItem(): bool
    {
        return $this->is_menu_item;
    }

    /**
     * Get menu icon with default fallback
     */
    public function getMenuIcon(): string
    {
        return $this->menu_icon ?: 'ki-duotone ki-abstract-26';
    }
}
