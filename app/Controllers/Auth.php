<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use App\Models\PerfilModel;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function acceder()
    {
        $session = session();
        $model = new UsuarioModel();
        $perfilModel = new PerfilModel();
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        $data = $model
            ->where('usuario', $usuario)
            ->where('password', $password)
            ->first();


        //echo $usuario.$password;
        //print_r($data);
        //if ($data && password_verify($password, $data['password'])) {
        // if (count($data)>=1) {    
        //     $perfil = $perfilModel->where('idUsuario', 1)->first();
        //    // print_r($perfil);
        //     $session->set([

        //         'idUsuario' => $data['id'],
        //         'usuario'   => $data['usuario'],
        //         'tipo'      => $data['tipo'],
        //         'logged_in' => true,
        //         'idioma' => $perfil['idiomaPreferido'] ?? 'es',
        //         'tamLetra' => $perfil['tamLetra'] ?? 'mediano',
        //         'velocidadAudio' => $perfil['velocidadAudio'] ?? 'normal',
        //         'contrasteAlto' => $perfil['contrasteAlto'] ?? 0
        //     ]);
        //      // Redirigir según tipo de usuario
        //     if ($data['tipo'] === 'admin') {
        //         return redirect()->to('/curso');
        //     } else {
        //          //print_r(session()->get());
        //         return redirect()->to('/dashboard');
        //     }
        // } else {
        //     return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        // }

        if ($data) {
            // Comparar en texto plano
            if ($password === $data['password']) {

                // Obtener perfil (si aplica)
                $perfil = $perfilModel->getPerfilByUsuario($data['id']);

                $session->set([
                    'idUsuario'       => $data['id'],
                    'usuario'         => $data['usuario'],
                    'tipo'            => $data['tipo'],
                    'logged_in'       => true,
                    'idioma'          => $perfil['idiomaPreferido'] ?? 'es',
                    'tamLetra'        => $perfil['tamLetra'] ?? 'mediano',
                    'velocidadAudio'  => $perfil['velocidadAudio'] ?? 'normal',
                    'contrasteAlto'   => $perfil['contrasteAlto'] ?? 0,
                ]);

                // Redirección según tipo
                return ($data['tipo'] === 'admin')
                    ? redirect()->to('/curso')
                    : redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Contraseña incorrecta');
            }
        } else {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
