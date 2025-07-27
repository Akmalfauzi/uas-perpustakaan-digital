<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'setting_key', 'setting_value', 'setting_type', 'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'setting_key' => 'required|max_length[100]',
        'setting_type' => 'required|in_list[string,number,boolean,json]'
    ];

    protected $validationMessages = [
        'setting_key' => [
            'required' => 'Setting key harus diisi',
            'max_length' => 'Setting key maksimal 100 karakter'
        ],
        'setting_type' => [
            'required' => 'Setting type harus diisi',
            'in_list' => 'Setting type tidak valid'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $this->castValue($setting['setting_value'], $setting['setting_type']);
    }

    /**
     * Set setting value
     */
    public function setSetting($key, $value, $type = 'string', $description = null)
    {
        $existing = $this->where('setting_key', $key)->first();
        
        $data = [
            'setting_key' => $key,
            'setting_value' => $this->prepareValue($value, $type),
            'setting_type' => $type,
            'description' => $description
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    /**
     * Get all settings as key-value array
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $this->castValue(
                $setting['setting_value'], 
                $setting['setting_type']
            );
        }

        return $result;
    }

    /**
     * Get settings by type
     */
    public function getSettingsByType($type)
    {
        $settings = $this->where('setting_type', $type)->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $this->castValue(
                $setting['setting_value'], 
                $setting['setting_type']
            );
        }

        return $result;
    }

    /**
     * Update multiple settings
     */
    public function updateSettings($settings)
    {
        $this->db->transStart();

        foreach ($settings as $key => $value) {
            // Get existing setting to preserve type
            $existing = $this->where('setting_key', $key)->first();
            $type = $existing ? $existing['setting_type'] : 'string';
            
            $this->setSetting($key, $value, $type, $existing['description'] ?? null);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Cast value based on type
     */
    private function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'number':
                return is_numeric($value) ? (int) $value : 0;
            case 'json':
                return json_decode($value, true);
            case 'string':
            default:
                return (string) $value;
        }
    }

    /**
     * Prepare value for storage
     */
    private function prepareValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'number':
                return (string) $value;
            case 'json':
                return json_encode($value);
            case 'string':
            default:
                return (string) $value;
        }
    }

    /**
     * Delete setting by key
     */
    public function deleteSetting($key)
    {
        return $this->where('setting_key', $key)->delete();
    }

    /**
     * Check if setting exists
     */
    public function hasSetting($key)
    {
        return $this->where('setting_key', $key)->first() !== null;
    }

    /**
     * Get settings for display (with metadata)
     */
    public function getSettingsForDisplay()
    {
        return $this->orderBy('setting_key', 'ASC')->findAll();
    }
} 