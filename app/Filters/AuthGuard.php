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
        $currentURIPath = '/' . $request->uri->getPath();

        // check if the current path is auth path, just return true
        // don't forget to use named routes to simplify the call
        if ($currentURIPath ==route_to('auth/login')) {
            return;
        } 

        if (!session()->get('current_user')) {
            return redirect()->to(base_url('auth/login'));
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}