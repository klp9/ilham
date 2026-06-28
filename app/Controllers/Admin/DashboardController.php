<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomModel;
use App\Models\UserModel;
use App\Models\BookingModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $roomModel = new RoomModel();
        $userModel = new UserModel();
        $bookingModel = new BookingModel();

        $totalRooms = $roomModel->countAllResults();
        $totalCustomers = $userModel->where('role', 'customer')->countAllResults();
        $totalBookings = $bookingModel->countAllResults();
        
        $incomeResult = $bookingModel->selectSum('total_price')
                                     ->whereIn('status', ['approved', 'check_in', 'check_out'])
                                     ->first();
        $totalIncome = $incomeResult['total_price'] ?? 0;

        $stats = [
            'pending'   => $bookingModel->where('status', 'pending')->countAllResults(),
            'approved'  => $bookingModel->where('status', 'approved')->countAllResults(),
            'rejected'  => $bookingModel->where('status', 'rejected')->countAllResults(),
            'check_in'  => $bookingModel->where('status', 'check_in')->countAllResults(),
            'check_out' => $bookingModel->where('status', 'check_out')->countAllResults(),
        ];

        $recentBookings = $bookingModel->getBookingsWithDetails();
        $recentBookings = array_slice($recentBookings, 0, 5);

        $data = [
            'totalRooms'     => $totalRooms,
            'totalCustomers' => $totalCustomers,
            'totalBookings'  => $totalBookings,
            'totalIncome'     => $totalIncome,
            'stats'          => $stats,
            'recentBookings' => $recentBookings,
        ];

        return view('admin/dashboard', $data);
    }
}
