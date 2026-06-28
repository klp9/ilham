<?php

namespace App\Controllers;

use App\Models\RoomModel;
use App\Models\CategoryModel;

class HomeController extends BaseController
{
    protected $roomModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
            'rooms'      => $this->roomModel->getRoomsWithCategory(null, null),
        ];
        return view('home', $data);
    }

    public function rooms()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('rooms/index', $data);
    }

    public function roomDetail($id)
    {
        $room = $this->roomModel->getRoomWithCategoryAndFacilities($id);
        
        if (!$room) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kamar dengan ID $id tidak ditemukan.");
        }

        $data = [
            'room' => $room,
        ];
        return view('rooms/detail', $data);
    }
}
