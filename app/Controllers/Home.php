<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\SettingsModel;

class Home extends BaseController
{
    public function index(): string
    {
        $bookModel = new BookModel();
        $settingsModel = new SettingsModel();
        
        // Get settings
        $siteName = $settingsModel->getSetting('site_name', 'Perpustakaan Digital');
        $siteDescription = $settingsModel->getSetting('site_description', 'Sistem Perpustakaan Digital');
        
        $data = [
            'title' => $siteName,
            'siteName' => $siteName,
            'siteDescription' => $siteDescription,
            'popularBooks' => $bookModel->getPopularBooks(6),
            'recentBooks' => $bookModel->getRecentBooks(6),
            'categories' => $bookModel->getCategories(),
            'statistics' => $bookModel->getStatistics()
        ];
        
        return view('home/index', $data);
    }
}
