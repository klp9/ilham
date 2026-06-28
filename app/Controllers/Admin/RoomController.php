<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomModel;
use App\Models\CategoryModel;
use App\Models\FacilityModel;

class RoomController extends BaseController
{
    protected $roomModel;
    protected $categoryModel;
    protected $facilityModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
        $this->categoryModel = new CategoryModel();
        $this->facilityModel = new FacilityModel();
    }

    public function index()
    {
        $data['rooms'] = $this->roomModel->getRoomsWithCategory();
        return view('admin/rooms/index', $data);
    }

    public function create()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
            'facilities' => $this->facilityModel->findAll(),
        ];
        return view('admin/rooms/create', $data);
    }

    public function store()
    {
        $rules = [
            'category_id' => 'required',
            'room_number' => 'required|is_unique[rooms.room_number]',
            'price'       => 'required|numeric',
            'status'      => 'required|in_list[available,booked,maintenance]',
            'description' => 'required',
            'image'       => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('image');
        $imageName = $imageFile->getRandomName();
        $imageFile->move(FCPATH . 'uploads/rooms', $imageName);

        $roomData = [
            'category_id' => $this->request->getPost('category_id'),
            'room_number' => $this->request->getPost('room_number'),
            'price'       => $this->request->getPost('price'),
            'status'      => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'image'       => $imageName,
        ];

        $this->roomModel->insert($roomData);
        $roomId = $this->roomModel->getInsertID();

        // Sync facilities
        $facilityIds = $this->request->getPost('facilities') ?? [];
        $this->facilityModel->syncRoomFacilities($roomId, $facilityIds);

        return redirect()->to('/admin/rooms')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return redirect()->to('/admin/rooms')->with('error', 'Kamar tidak ditemukan.');
        }

        $roomFacilities = $this->facilityModel->getRoomFacilities($id);
        $currentFacilityIds = array_column($roomFacilities, 'id');

        $data = [
            'room'               => $room,
            'categories'         => $this->categoryModel->findAll(),
            'facilities'         => $this->facilityModel->findAll(),
            'currentFacilityIds' => $currentFacilityIds,
        ];

        return view('admin/rooms/edit', $data);
    }

    public function update($id)
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return redirect()->to('/admin/rooms')->with('error', 'Kamar tidak ditemukan.');
        }

        $rules = [
            'category_id' => 'required',
            'room_number' => "required|is_unique[rooms.room_number,id,$id]",
            'price'       => 'required|numeric',
            'status'      => 'required|in_list[available,booked,maintenance]',
            'description' => 'required',
        ];

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $rules['image'] = 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $roomData = [
            'category_id' => $this->request->getPost('category_id'),
            'room_number' => $this->request->getPost('room_number'),
            'price'       => $this->request->getPost('price'),
            'status'      => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
        ];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            if ($room['image'] && file_exists(FCPATH . 'uploads/rooms/' . $room['image'])) {
                unlink(FCPATH . 'uploads/rooms/' . $room['image']);
            }
            $imageName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/rooms', $imageName);
            $roomData['image'] = $imageName;
        }

        $this->roomModel->update($id, $roomData);

        $facilityIds = $this->request->getPost('facilities') ?? [];
        $this->facilityModel->syncRoomFacilities($id, $facilityIds);

        return redirect()->to('/admin/rooms')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return redirect()->to('/admin/rooms')->with('error', 'Kamar tidak ditemukan.');
        }

        if ($room['image'] && file_exists(FCPATH . 'uploads/rooms/' . $room['image'])) {
            unlink(FCPATH . 'uploads/rooms/' . $room['image']);
        }

        $this->roomModel->delete($id);
        return redirect()->to('/admin/rooms')->with('success', 'Kamar berhasil dihapus.');
    }
}
