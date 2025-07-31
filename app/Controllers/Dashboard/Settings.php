<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\SettingsImageModel;


class Settings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SettingsModel();
    }

    // Dashboard → Settings
    public function index()
    {
        $settingsModel      = $this->model;
        $settingsImageModel = new \App\Models\SettingsImageModel();

        $data = [
            'title'      => 'Settings',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings'],
            ],
            'settings' => $settingsModel->first(),
            'banners'  => $settingsImageModel
                ->whereIn('type', ['home', 'about', 'property', 'blog', 'contact']) // Ambil hanya banner-page
                ->orderBy('type', 'ASC') // gunakan 'type' bukan 'title'
                ->findAll(),
        ];

        return view('admin/settings/index', $data);
    }



    // Dashboard → Settings → Site Info
    public function siteInfo()
    {
        $data = [
            'title'      => 'Site Info',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Site Info'],
            ],
            'settings'   => $this->model->first(),
        ];
        return view('admin/settings/site_info', $data);
    }

    public function saveSiteInfo()
    {
        helper('form');
        $rules = ['site_name' => 'required|min_length[3]'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $post = $this->request->getPost();
        $data = [
            'site_name'  => $post['site_name'],
            'tagline'    => $post['tagline'],
            'about'      => $post['about'],
            'location'   => $post['location'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->model->find(1)) {
            $this->model->update(1, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->model->insert($data);
        }

        return redirect()
            ->to(base_url('dashboard/settings'))
            ->with('success', 'Site Info updated.');
    }

    // Dashboard → Settings → Contact & Social
    public function contactSocial()
    {
        $data = [
            'title'      => 'Contact & Social',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Contact & Social'],
            ],
            'settings'   => $this->model->first(),
        ];
        return view('admin/settings/contact_social', $data);
    }

    public function saveContactSocial()
    {
        helper('form');
        $rules = [
            'phone'     => 'permit_empty|regex_match[/^[0-9+\\-\\s]+$/]',
            'instagram' => 'permit_empty',
            'tiktok'    => 'permit_empty',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $post = $this->request->getPost();
        $data = [
            'phone'       => $post['phone'],
            'instagram'   => $post['instagram'],
            'tiktok'      => $post['tiktok'],
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if ($this->model->find(1)) {
            $this->model->update(1, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->model->insert($data);
        }

        return redirect()
            ->to(base_url('dashboard/settings'))
            ->with('success', 'Contact & Social updated.');
    }

    // Dashboard → Settings → Logo & Icon
    public function logoIcon()
    {
        $data = [
            'title'      => 'Logo & Icon',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Logo & Icon'],
            ],
            'settings'   => $this->model->first(),
        ];
        return view('admin/settings/logo_icon', $data);
    }

    public function saveLogoIcon()
    {
        $data = ['updated_at' => date('Y-m-d H:i:s')];

        $logo = $this->request->getFile('site_logo');
        if ($logo && $logo->isValid() && ! $logo->hasMoved()) {
            $name = 'logo_' . time() . '.' . $logo->getExtension();
            $logo->move('uploads', $name);
            $data['site_logo'] = $name;
        }

        $icon = $this->request->getFile('site_icon');
        if ($icon && $icon->isValid() && ! $icon->hasMoved()) {
            $name = 'icon_' . time() . '.' . $icon->getExtension();
            $icon->move('uploads', $name);
            $data['site_icon'] = $name;
        }

        if ($this->model->find(1)) {
            $this->model->update(1, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->model->insert($data);
        }

        return redirect()
            ->to(base_url('dashboard/settings'))
            ->with('success', 'Logo & Icon updated.');
    }

    // Dashboard → Settings → Locale Settings
    public function locale()
    {
        $data = [
            'title'      => 'Locale Settings',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Locale Settings'],
            ],
            'settings'   => $this->model->first(),
        ];
        return view('admin/settings/locale', $data);
    }

    public function saveLocale()
    {
        $post = $this->request->getPost();
        $data = [
            'timezone'        => $post['timezone'] ?: 'UTC',
            'language'        => $post['language'] ?: 'en',
            'date_format'     => $post['date_format'] ?: 'Y-m-d',
            'datetime_format' => $post['datetime_format'] ?: 'Y-m-d H:i:s',
            'maintenance'     => isset($post['maintenance']) ? 1 : 0,
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        if ($this->model->find(1)) {
            $this->model->update(1, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->model->insert($data);
        }

        return redirect()
            ->to(base_url('dashboard/settings'))
            ->with('success', 'Locale Settings updated.');
    }

    // Dashboard → Settings → Maintenance Mode (alternate view)
    public function maintenance()
    {
        $data = [
            'title'      => 'Maintenance Mode',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Maintenance Mode'],
            ],
            'settings'   => $this->model->first(),
        ];
        return view('admin/settings/maintenance', $data);
    }

    public function saveMaintenance()
    {
        $data = [
            'maintenance' => $this->request->getPost('maintenance') ? 1 : 0,
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if ($this->model->find(1)) {
            $this->model->update(1, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->model->insert($data);
        }

        return redirect()
            ->to(base_url('dashboard/settings'))
            ->with('success', 'Maintenance Mode updated.');
    }

    public function banner()
    {
        $bannerModel = new SettingsImageModel();
        $banners = $bannerModel->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/settings/banner', [
            'title' => 'Banner Image Settings',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Banner Images']
            ],
            'banners' => $banners
        ]);
    }

    public function saveBanner()
{
    $model = new SettingsImageModel();
    $id = $this->request->getPost('id');

    $data = [
        'type'       => $this->request->getPost('type'),
        'status'     => $this->request->getPost('status'),
        'sort_order' => $this->request->getPost('sort_order') ?? 0,
    ];

    // Upload file jika ada
    $file = $this->request->getFile('filename');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/settings/banner/', $newName);
        $data['filename'] = $newName;

        // Jika update, hapus file lama
        if ($id) {
            $old = $model->find($id);
            if ($old && !empty($old['filename'])) {
                $oldPath = FCPATH . 'uploads/settings/banner/' . $old['filename'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        }
    }

    if ($id) {
        $model->update($id, $data);
    } else {
        $model->insert($data);
    }

    return redirect()->to(base_url('dashboard/settings/banner'))->with('success', 'Banner saved successfully.');
}


    public function deleteBanner($id)
{
    $model = new SettingsImageModel();
    $banner = $model->find($id);

    if ($banner && !empty($banner['filename'])) {
        $filePath = FCPATH . 'uploads/settings/banner/' . $banner['filename'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $model->delete($id);

    return redirect()->to(base_url('dashboard/settings/banner'))->with('success', 'Banner deleted successfully.');
}




}
