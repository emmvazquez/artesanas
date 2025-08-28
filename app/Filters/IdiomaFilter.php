<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IdiomaFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $idioma = session()->get('idioma') ?? 'es';
        service('request')->setLocale($idioma);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nada
    }
}
