<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table            = 'rooms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id', 'room_number', 'price', 'status', 'description', 'image'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRoomsWithCategory($categoryId = null, $search = null)
    {
        $builder = $this->select('rooms.*, categories.name as category_name')
                        ->join('categories', 'categories.id = rooms.category_id');

        if ($categoryId) {
            $builder->where('rooms.category_id', $categoryId);
        }

        if ($search) {
            $builder->groupStart()
                    ->like('rooms.room_number', $search)
                    ->orLike('rooms.description', $search)
                    ->orLike('categories.name', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getRoomWithCategoryAndFacilities($id)
    {
        $room = $this->select('rooms.*, categories.name as category_name')
                     ->join('categories', 'categories.id = rooms.category_id')
                     ->where('rooms.id', $id)
                     ->first();

        if ($room) {
            $room['facilities'] = $this->db->table('room_facilities')
                                           ->select('facilities.*')
                                           ->join('facilities', 'facilities.id = room_facilities.facility_id')
                                           ->where('room_facilities.room_id', $id)
                                           ->get()
                                           ->getResultArray();
        }

        return $room;
    }
}
