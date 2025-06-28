<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;

class Property extends BaseController
{
    protected $propertyModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
    }

    public function index()
    {
        helper('number');

            $data = [
            'title' => 'Property Listing',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property']
            ],
            'properties' => $this->propertyModel->findAll(),
        ];

        return view('admin/property/index', $data);

    }

    public function create()
    {
        $data = [
            'title' => 'Add Property',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Add Property']
            ],
        ];

        return view('admin/property/create', $data);
    }

    public function store()
    {
        $this->propertyModel->save([
            'title' => $this->request->getPost('title'),
            'location' => $this->request->getPost('location'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/dashboard/property')->with('success', 'Property added successfully.');
    }

    public function edit($id)
    {
        $property = $this->propertyModel->find($id);

        $data = [
            'title' => 'Edit Property',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Edit Property']
            ],
            'property' => $property
        ];

        return view('admin/property/edit', $data);
    }

    public function update($id)
    {
        $this->propertyModel->update($id, [
            'title' => $this->request->getPost('title'),
            'location' => $this->request->getPost('location'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/dashboard/property')->with('success', 'Property updated successfully.');
    }

    public function delete($id)
    {
        $this->propertyModel->delete($id);

        return redirect()->to('/dashboard/property')->with('success', 'Property deleted successfully.');
    }
}
