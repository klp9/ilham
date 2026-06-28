<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\RoomModel;
use App\Models\PaymentModel;

class BookingController extends BaseController
{
    protected $bookingModel;
    protected $roomModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->roomModel = new RoomModel();
        $this->paymentModel = new PaymentModel();
    }

    public function create()
    {
        $roomId = $this->request->getPost('room_id');
        $room = $this->roomModel->find($roomId);

        if (!$room) {
            return redirect()->back()->with('error', 'Kamar tidak ditemukan.');
        }

        if ($room['status'] !== 'available') {
            return redirect()->back()->with('error', 'Kamar tidak tersedia untuk dipesan.');
        }

        $rules = [
            'check_in_date'  => 'required|valid_date[Y-m-d]',
            'check_out_date' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $checkInDate = $this->request->getPost('check_in_date');
        $checkOutDate = $this->request->getPost('check_out_date');

        if (strtotime($checkInDate) >= strtotime($checkOutDate)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal Check-Out harus setelah tanggal Check-In.');
        }

        $checkIn = new \DateTime($checkInDate);
        $checkOut = new \DateTime($checkOutDate);
        $days = $checkIn->diff($checkOut)->days;
        if ($days <= 0) {
            $days = 1;
        }

        $totalPrice = $room['price'] * $days;

        $bookingData = [
            'user_id'        => session()->get('userId'),
            'room_id'        => $roomId,
            'check_in_date'  => $checkInDate,
            'check_out_date' => $checkOutDate,
            'total_price'    => $totalPrice,
            'status'         => 'pending',
        ];

        $this->bookingModel->insert($bookingData);
        $bookingId = $this->bookingModel->getInsertID();

        return redirect()->to("/customer/bookings/detail/$bookingId")->with('success', 'Pemesanan berhasil dibuat! Silakan unggah bukti pembayaran.');
    }

    public function detail($id)
    {
        $booking = $this->bookingModel->getBookingWithDetails($id);
        
        if (!$booking || $booking['user_id'] != session()->get('userId')) {
            return redirect()->to('/customer/dashboard')->with('error', 'Pemesanan tidak ditemukan.');
        }

        $data['booking'] = $booking;
        return view('customer/booking_detail', $data);
    }

    public function uploadPayment($id)
    {
        $booking = $this->bookingModel->find($id);

        if (!$booking || $booking['user_id'] != session()->get('userId')) {
            return redirect()->to('/customer/dashboard')->with('error', 'Pemesanan tidak ditemukan.');
        }

        $rules = [
            'payment_method' => 'required',
            'proof_image'    => 'uploaded[proof_image]|max_size[proof_image,2048]|is_image[proof_image]|mime_in[proof_image,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('proof_image');
        $imageName = $imageFile->getRandomName();
        $imageFile->move(FCPATH . 'uploads/payments', $imageName);

        $existingPayment = $this->paymentModel->where('booking_id', $id)->first();

        $paymentData = [
            'booking_id'     => $id,
            'amount'         => $booking['total_price'],
            'payment_method' => $this->request->getPost('payment_method'),
            'proof_image'    => $imageName,
            'status'         => 'pending',
        ];

        if ($existingPayment) {
            if ($existingPayment['proof_image'] && file_exists(FCPATH . 'uploads/payments/' . $existingPayment['proof_image'])) {
                unlink(FCPATH . 'uploads/payments/' . $existingPayment['proof_image']);
            }
            $this->paymentModel->update($existingPayment['id'], $paymentData);
        } else {
            $this->paymentModel->insert($paymentData);
        }

        return redirect()->to("/customer/bookings/detail/$id")->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
    }
}
