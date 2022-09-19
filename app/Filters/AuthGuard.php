<?php 

namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // get the current URL path, like "auth/login"
        $currentURIPath = $request->uri->getPath();
        if ($currentURIPath != '/') {
            $currentURIPath = '/' . $currentURIPath;
        }

        if ($currentURIPath == route_to('login')
            || $currentURIPath == route_to('register')
            || $currentURIPath == route_to('register/success')
            || str_starts_with($currentURIPath, '/activate')
            || $currentURIPath == route_to('activate/success')) {
            return;
        }
        
        if (!session()->get('current_user')) {    
            return redirect()->to(base_url('login'));
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}