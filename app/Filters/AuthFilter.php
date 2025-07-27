<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Check if user is admin for admin routes
        $uri = $request->getUri();
        if (strpos($uri->getPath(), 'admin') !== false) {
            if ($session->get('userRole') !== 'admin') {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki akses admin');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
} 