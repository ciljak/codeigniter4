<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UsersCheck implements FilterInterface
{
    public function before(RequestInterface $request, $dumy=NULL)
    {
        // Do something here
        // If segment 1 == users
        //we have to redirect the request to the second segment
       /* $uri = service('uri');
        $segment = '/'; // default redirect
        if($uri->getSegment(1) == 'users'){
          if($uri->getSegment(2) == '')
            $segment = '/users';
         // else
         //   $segment = '/'.$uri->getSegment(2);

          return redirect()->to($segment);

        }

        if($uri->getSegment(1) == 'users'){
          if($uri->getSegment(2) == 'register')
            $segment = '/users/register';
         

          return redirect()->to($segment);

        }*/
        $uri = service('uri');
        if(($uri->getSegment(1) == 'users') && ($uri->getSegment(2) == '') ) {
          //return redirect()->to('users/'); no redirect
        }

        if(($uri->getSegment(1) == 'users') && ($uri->getSegment(2) == 'register') ) {
          //return redirect()->to('register');
        }
        if(($uri->getSegment(1) == 'users') && ($uri->getSegment(2) == 'logout') ) {
         // return redirect()->to('users/logout');
        }
        if(($uri->getSegment(1) == 'users') && ($uri->getSegment(2) == 'profile') ) {
         // return redirect()->to('users/profile');
        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $dumy=NULL)
    {
        // Do something here
    }
}
