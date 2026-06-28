<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\PaymentModel;
use App\Models\RoomModel;

class BookingController extends BaseController
{
    protected $bookingModel;
    protected $paymentModel;
    protected $roomModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->paymentModel = new PaymentModel();
        $this->roomModel = new RoomModel();
    }

    public function index()
    {
        $data['bookings'] = $this->bookingModel->getBookingsWithDetails();
        return view('admin/bookings/index', $data);
    }

    public function detail($id)
    {
        $booking = $this->bookingModel->getBookingWithDetails($id);
        if (!$booking) {
            return redirect()->to('/admin/bookings')->with('error', 'Pemesanan tidak ditemukan.');
        }

        $data['booking'] = $booking;
        return view('admin/bookings/detail', $data);
    }

    public function updateStatus($id)
    {
        $booking = $this->bookingModel->find($id);
        if (!$booking) {
            return redirect()->to('/admin/bookings')->with('error', 'Pemesanan tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        $validStatuses = ['pending', 'approved', 'rejected', 'check_in', 'check_out'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->bookingModel->update($id, ['status' => $status]);

        // Update room status based on booking status
        $roomStatus = 'available';
        if ($status === 'approved' || $status === 'check_in') {
            $roomStatus = 'booked';
        }
        $this->roomModel->update($booking['room_id'], ['status' => $roomStatus]);

        // If there's a payment associated, update payment status too
        $payment = $this->paymentModel->where('booking_id', $id)->first();
        if ($payment) {
            $paymentStatus = 'pending';
            if ($status === 'approved' || $status === 'check_in' || $status === 'check_out') {
                $paymentStatus = 'verified';
            } elseif ($status === 'rejected') {
                $paymentStatus = 'rejected';
            }
            $this->paymentModel->update($payment['id'], ['status' => $paymentStatus]);
        }

        return redirect()->to("/admin/bookings/detail/$id")->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    public function reports()
    {
        $startDate = $this->request->getVar('start_date');
        $endDate = $this->request->getVar('end_date');
        $status = $this->request->getVar('status');

        $builder = $this->bookingModel->select('bookings.*, rooms.room_number, categories.name as category_name, users.fullname as customer_name')
                                      ->join('rooms', 'rooms.id = bookings.room_id')
                                      ->join('categories', 'categories.id = rooms.category_id')
                                      ->join('users', 'users.id = bookings.user_id')
                                      ->orderBy('bookings.created_at', 'ASC');

        if ($startDate) {
            $builder->where('bookings.check_in_date >=', $startDate);
        }
        if ($endDate) {
            $builder->where('bookings.check_in_date <=', $endDate);
        }
        if ($status) {
            $builder->where('bookings.status', $status);
        }

        $bookings = $builder->findAll();

        $totalBookings = count($bookings);
        $totalRevenue = 0;
        foreach ($bookings as $b) {
            if (in_array($b['status'], ['approved', 'check_in', 'check_out'])) {
                $totalRevenue += $b['total_price'];
            }
        }

        $data = [
            'bookings'      => $bookings,
            'totalBookings' => $totalBookings,
            'totalRevenue'  => $totalRevenue,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
            'statusFilter'  => $status,
        ];

        return view('admin/reports/index', $data);
    }
}
