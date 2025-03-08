<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group',
        'key',
        'value',
        'display_name',
        'description',
        'order',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'array',
    ];
    
    /**
     * Get a setting by group and key
     *
     * @param string $group
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $group, string $key, $default = null)
    {
        $setting = static::where('group', $group)
            ->where('key', $key)
            ->first();
            
        return $setting ? $setting->value : $default;
    }
    
    /**
     * Set a setting value
     *
     * @param string $group
     * @param string $key
     * @param mixed $value
     * @param string|null $displayName
     * @param string|null $description
     * @param int $order
     * @return Setting
     */
    public static function set(string $group, string $key, $value, ?string $displayName = null, ?string $description = null, int $order = 0)
    {
        $setting = static::firstOrNew([
            'group' => $group,
            'key' => $key,
        ]);
        
        $setting->value = $value;
        
        if ($displayName !== null) {
            $setting->display_name = $displayName;
        }
        
        if ($description !== null) {
            $setting->description = $description;
        }
        
        if (!$setting->exists) {
            $setting->order = $order;
        }
        
        $setting->save();
        
        return $setting;
    }
    
    /**
     * Get all settings for a specific group
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public static function getGroup(string $group)
    {
        return static::where('group', $group)
            ->orderBy('order')
            ->get()
            ->pluck('value', 'key');
    }
    
    /**
     * Check if a setting exists
     *
     * @param string $group
     * @param string $key
     * @return bool
     */
    public static function has(string $group, string $key): bool
    {
        return static::where('group', $group)
            ->where('key', $key)
            ->exists();
    }
    
    /**
     * Delete a setting
     *
     * @param string $group
     * @param string $key
     * @return bool
     */
    public static function remove(string $group, string $key): bool
    {
        return (bool) static::where('group', $group)
            ->where('key', $key)
            ->delete();
    }
}
