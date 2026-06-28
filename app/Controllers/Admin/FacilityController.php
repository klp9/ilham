<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FacilityModel;

class FacilityController extends BaseController
{
    protected $facilityModel;

    public function __construct()
    {
        $this->facilityModel = new FacilityModel();
    }

    public function index()
    {
        $data['facilities'] = $this->facilityModel->findAll();
        return view('admin/facilities/index', $data);
    }

    public function create()
    {
        return view('admin/facilities/create');
    }

    public function store()
    {
        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->facilityModel->save([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/facilities')->with('success', 'Fasilitas kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $facility = $this->facilityModel->find($id);
        if (!$facility) {
            return redirect()->to('/admin/facilities')->with('error', 'Fasilitas tidak ditemukan.');
        }

        $data['facility'] = $facility;
        return view('admin/facilities/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->facilityModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/facilities')->with('success', 'Fasilitas kamar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $facility = $this->facilityModel->find($id);
        if (!$facility) {
            return redirect()->to('/admin/facilities')->with('error', 'Fasilitas tidak ditemukan.');
        }

        $this->facilityModel->delete($id);
        return redirect()->to('/admin/facilities')->with('success', 'Fasilitas kamar berhasil dihapus.');
    }
}
