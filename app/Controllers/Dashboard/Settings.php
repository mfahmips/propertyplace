<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\SettingsImageModel;

class Settings extends BaseController
{
    protected $model;
    protected $imageModel;

    public function __construct()
    {
        $this->model = new SettingsModel();
        $this->imageModel = new SettingsImageModel();
    }

    // =============================
    // DASHBOARD → SETTINGS (INDEX)
    // =============================
    public function index()
    {
        $data = [
            'title'      => 'Settings',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings'],
            ],
            'settings' => $this->model->first(),
            'banners'  => $this->imageModel
                ->whereIn('type', ['home', 'about', 'property', 'blog', 'contact'])
                ->orderBy('type', 'ASC')
                ->findAll(),
        ];

        return view('admin/settings/index', $data);
    }

    // =============================
    // SITE INFO
    // =============================
    public function siteInfo()
    {
        return view('admin/settings/site_info', [
            'title' => 'Site Info',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Site Info'],
            ],
            'settings' => $this->model->first(),
        ]);
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

        $this->model->save($data + ['id' => 1]);

        return redirect()->to(base_url('dashboard/settings'))->with('success', 'Site Info updated.');
    }

    // =============================
    // CONTACT & SOCIAL
    // =============================
    public function contactSocial()
    {
        return view('admin/settings/contact_social', [
            'title' => 'Contact & Social',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Contact & Social'],
            ],
            'settings' => $this->model->first(),
        ]);
    }

    public function saveContactSocial()
    {
        helper('form');
        $rules = [
            'phone'     => 'permit_empty|regex_match[/^[0-9+\-\s]+$/]',
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

        $this->model->save($data + ['id' => 1]);

        return redirect()->to(base_url('dashboard/settings'))->with('success', 'Contact & Social updated.');
    }

    // =============================
    // LOGO & ICON
    // =============================
    public function logoIcon()
    {
        return view('admin/settings/logo_icon', [
            'title' => 'Logo & Icon',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Logo & Icon'],
            ],
            'settings' => $this->model->first(),
        ]);
    }

    public function saveLogoIcon()
    {
        $data = ['updated_at' => date('Y-m-d H:i:s')];

        // Upload Logo
        $logo = $this->request->getFile('site_logo');
        if ($logo && $logo->isValid() && ! $logo->hasMoved()) {
            $name = 'logo_' . time() . '.' . $logo->getExtension();
            $logo->move('uploads', $name);
            $data['site_logo'] = $name;
        }

        // Upload Icon
        $icon = $this->request->getFile('site_icon');
        if ($icon && $icon->isValid() && ! $icon->hasMoved()) {
            $name = 'icon_' . time() . '.' . $icon->getExtension();
            $icon->move('uploads', $name);
            $data['site_icon'] = $name;
        }

        $this->model->save($data + ['id' => 1]);

        return redirect()->to(base_url('dashboard/settings'))->with('success', 'Logo & Icon updated.');
    }

    // =============================
    // LOCALE SETTINGS
    // =============================
    public function locale()
    {
        return view('admin/settings/locale', [
            'title' => 'Locale Settings',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Locale Settings'],
            ],
            'settings' => $this->model->first(),
        ]);
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

        $this->model->save($data + ['id' => 1]);

        return redirect()->to(base_url('dashboard/settings'))->with('success', 'Locale Settings updated.');
    }

    // =============================
    // MAINTENANCE MODE
    // =============================
    public function maintenance()
    {
        return view('admin/settings/maintenance', [
            'title' => 'Maintenance Mode',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Maintenance Mode'],
            ],
            'settings' => $this->model->first(),
        ]);
    }

    public function saveMaintenance()
    {
        $data = [
            'maintenance' => $this->request->getPost('maintenance') ? 1 : 0,
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->model->save($data + ['id' => 1]);

        return redirect()->to(base_url('dashboard/settings'))->with('success', 'Maintenance Mode updated.');
    }

    // =============================
    // BANNER MANAGEMENT
    // =============================
    public function banner()
    {
        $banners = $this->imageModel->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/settings/banner', [
            'title' => 'Banner Image Settings',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Settings', 'url' => base_url('dashboard/settings')],
                ['label' => 'Banner Images'],
            ],
            'banners' => $banners
        ]);
    }

    public function saveBanner()
    {
        $id = $this->request->getPost('id');

        $data = [
            'type'       => $this->request->getPost('type'),
            'status'     => $this->request->getPost('status') ?: 'active',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ];

        // Upload File
        $file = $this->request->getFile('filename');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/settings/banner/', $newName);
            $data['filename'] = $newName;

            // Hapus lama jika update
            if ($id) {
                $old = $this->imageModel->find($id);
                if ($old && !empty($old['filename'])) {
                    $oldPath = FCPATH . 'uploads/settings/banner/' . $old['filename'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }
        }

        $id ? $this->imageModel->update($id, $data) : $this->imageModel->insert($data);

        return redirect()->to(base_url('dashboard/settings/banner'))->with('success', 'Banner saved successfully.');
    }

    public function deleteBanner($id)
    {
        $banner = $this->imageModel->find($id);

        if ($banner && !empty($banner['filename'])) {
            $filePath = FCPATH . 'uploads/settings/banner/' . $banner['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->imageModel->delete($id);

        return redirect()->to(base_url('dashboard/settings/banner'))->with('success', 'Banner deleted successfully.');
    }

    // =============================
// THEME COLORS
// =============================
public function themeColors()
{
    return view('admin/settings/theme_colors', [
        'title'    => 'Pengaturan Tema Warna',
        'settings' => $this->model->first(),
    ]);
}

/**
 * Simpan pengaturan tema warna
 */
public function saveThemeColors()
{
    $data = [
        'theme_primary_color'      => $this->request->getPost('theme_primary_color'),
        'theme_primary_hover'      => $this->request->getPost('theme_primary_hover'),
        'theme_background_color'   => $this->request->getPost('theme_background_color'),
        'theme_panel_color'        => $this->request->getPost('theme_panel_color'),
        'theme_card_color'         => $this->request->getPost('theme_card_color'),
        'theme_text_color'         => $this->request->getPost('theme_text_color'),
        'theme_muted_text_color'   => $this->request->getPost('theme_muted_text_color'),
        'updated_at'               => date('Y-m-d H:i:s'),
    ];

    // Simpan semua data ke row ID=1 (global settings)
    $this->model->updateSettings($data);

    return redirect()->back()->with('success', '🎨 Tema warna berhasil diperbarui!');
}

}
