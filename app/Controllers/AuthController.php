<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectUserBasedOnRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau Password salah.');
        }

        $sessionData = [
            'userId'     => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'fullname'   => $user['fullname'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ];

        session()->set($sessionData);

        return $this->redirectUserBasedOnRole($user['role'])->with('success', 'Selamat datang kembali, ' . $user['fullname']);
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectUserBasedOnRole(session()->get('role'));
        }
        return view('auth/register');
    }

    public function registerProcess()
    {
        $rules = [
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'fullname' => 'required',
            'phone'    => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'fullname' => $this->request->getPost('fullname'),
            'phone'    => $this->request->getPost('phone'),
            'role'     => 'customer',
        ];

        $this->userModel->save($data);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }

    private function redirectUserBasedOnRole($role)
    {
        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/customer/dashboard');
    }
}
