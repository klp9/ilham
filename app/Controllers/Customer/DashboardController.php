<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    protected $bookingModel;
    protected $userModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('userId');
        
        $data = [
            'bookings' => $this->bookingModel->getBookingsWithDetails($userId),
            'user'     => $this->userModel->find($userId),
        ];

        return view('customer/dashboard', $data);
    }

    public function profile()
    {
        $userId = session()->get('userId');
        $data['user'] = $this->userModel->find($userId);
        return view('customer/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('userId');

        $rules = [
            'fullname' => 'required',
            'phone'    => 'required|numeric',
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'phone'    => $this->request->getPost('phone'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($userId, $data);

        session()->set('fullname', $data['fullname']);

        return redirect()->to('/customer/profile')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
