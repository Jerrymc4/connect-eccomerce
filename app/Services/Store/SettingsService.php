<?php

namespace App\Services\Store;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

/**
 * Service to manage store settings within each store's database
 */
class SettingsService
{
    /**
     * Get a store setting
     *
     * @param string $group
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $group, string $key, $default = null)
    {
        return Setting::get($group, $key, $default);
    }
    
    /**
     * Get all settings for a specific group
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public function getGroup(string $group)
    {
        return Setting::getGroup($group);
    }
    
    /**
     * Set a store setting
     *
     * @param string $group
     * @param string $key
     * @param mixed $value
     * @param string|null $displayName
     * @param string|null $description
     * @return Setting
     */
    public function set(string $group, string $key, $value, ?string $displayName = null, ?string $description = null)
    {
        return Setting::set($group, $key, $value, $displayName, $description);
    }
    
    /**
     * Delete a store setting
     *
     * @param string $group
     * @param string $key
     * @return bool
     */
    public function delete(string $group, string $key): bool
    {
        return Setting::remove($group, $key);
    }
    
    /**
     * Get all theme settings
     *
     * @return \Illuminate\Support\Collection
     */
    public function getThemeSettings()
    {
        return $this->getGroup('theme');
    }
    
    /**
     * Update theme settings
     *
     * @param array $settings
     * @return void
     */
    public function updateThemeSettings(array $settings)
    {
        DB::transaction(function () use ($settings) {
            foreach ($settings as $key => $value) {
                $this->set('theme', $key, $value);
            }
        });
    }
    
    /**
     * Get all store general settings
     *
     * @return \Illuminate\Support\Collection
     */
    public function getStoreSettings()
    {
        return $this->getGroup('store');
    }
    
    /**
     * Get regional settings (timezone, etc.)
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRegionalSettings()
    {
        return $this->getGroup('regional');
    }
    
    /**
     * Get payment settings
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPaymentSettings()
    {
        return $this->getGroup('payment');
    }
} 