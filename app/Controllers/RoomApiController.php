<?php

namespace App\Controllers;

use App\Models\RoomModel;
use CodeIgniter\API\ResponseTrait;

class RoomApiController extends BaseController
{
    use ResponseTrait;

    protected $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }

    public function index()
    {
        $categoryId = $this->request->getVar('category_id');
        $search = $this->request->getVar('search');

        $rooms = $this->roomModel->getRoomsWithCategory($categoryId, $search);

        // Attach facilities to each room
        $db = \Config\Database::connect();
        foreach ($rooms as &$room) {
            $room['facilities'] = $db->table('room_facilities')
                ->select('facilities.name')
                ->join('facilities', 'facilities.id = room_facilities.facility_id')
                ->where('room_facilities.room_id', $room['id'])
                ->get()
                ->getResultArray();
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Daftar kamar berhasil diambil.',
            'data'    => $rooms
        ], 200);
    }
}
