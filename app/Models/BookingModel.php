<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'room_id', 'check_in_date', 'check_out_date', 'total_price', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBookingsWithDetails($userId = null)
    {
        $builder = $this->select('bookings.*, rooms.room_number, categories.name as category_name, users.fullname as customer_name, users.email as customer_email, payments.proof_image, payments.status as payment_status, payments.payment_method')
                        ->join('rooms', 'rooms.id = bookings.room_id')
                        ->join('categories', 'categories.id = rooms.category_id')
                        ->join('users', 'users.id = bookings.user_id')
                        ->join('payments', 'payments.booking_id = bookings.id', 'left')
                        ->orderBy('bookings.created_at', 'DESC');

        if ($userId) {
            $builder->where('bookings.user_id', $userId);
        }

        return $builder->findAll();
    }

    public function getBookingWithDetails($id)
    {
        return $this->select('bookings.*, rooms.room_number, rooms.price as room_price, categories.name as category_name, users.fullname as customer_name, users.phone as customer_phone, users.email as customer_email, payments.proof_image, payments.status as payment_status, payments.payment_method, payments.id as payment_id')
                    ->join('rooms', 'rooms.id = bookings.room_id')
                    ->join('categories', 'categories.id = rooms.category_id')
                    ->join('users', 'users.id = bookings.user_id')
                    ->join('payments', 'payments.booking_id = bookings.id', 'left')
                    ->where('bookings.id', $id)
                    ->first();
    }
}
