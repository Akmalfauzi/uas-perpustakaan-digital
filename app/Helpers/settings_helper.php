<?php

if (!function_exists('getSetting')) {
    /**
     * Get setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getSetting($key, $default = null)
    {
        static $settingsModel = null;
        
        if ($settingsModel === null) {
            $settingsModel = new \App\Models\SettingsModel();
        }
        
        return $settingsModel->getSetting($key, $default);
    }
}

if (!function_exists('getAllSettings')) {
    /**
     * Get all settings as array
     * 
     * @return array
     */
    function getAllSettings()
    {
        static $settingsModel = null;
        
        if ($settingsModel === null) {
            $settingsModel = new \App\Models\SettingsModel();
        }
        
        return $settingsModel->getAllSettings();
    }
}

if (!function_exists('setSetting')) {
    /**
     * Set setting value
     * 
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string $description
     * @return bool
     */
    function setSetting($key, $value, $type = 'string', $description = null)
    {
        static $settingsModel = null;
        
        if ($settingsModel === null) {
            $settingsModel = new \App\Models\SettingsModel();
        }
        
        return $settingsModel->setSetting($key, $value, $type, $description);
    }
} 