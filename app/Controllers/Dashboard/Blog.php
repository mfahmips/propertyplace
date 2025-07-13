<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Blog extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
            $data = [
            'title'      => 'Manajemen Blog',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Blog']
            ],
            'blogs' => $this->blogModel->paginate(10, 'blogs'),
            'pager' => $this->blogModel->pager
        ];

        return view('admin/blog/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Blog',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Blog', 'url' => base_url('dashboard/blog')],
                ['label' => 'Tambah']
            ]
        ];
        return view('admin/blog/create', $data);
    }


    public function store()
    {
        $request = service('request');

        // Ambil data post
        $title   = $request->getPost('title');
        $content = $request->getPost('content');

        // Validasi: content tidak boleh kosong (trim untuk buang spasi & tag kosong)
        if (empty(trim(strip_tags($content)))) {
            return redirect()->back()->withInput()->with('error', 'Konten blog tidak boleh kosong.');
        }

        // Buat slug dari judul
        $slug = url_title($title, '-', true);

        // Upload cover image ke /public/uploads/blog
        $coverImage = $request->getFile('cover_image');
        $imageName = null;

        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            $imageName = $coverImage->getRandomName();
            $coverImage->move(FCPATH . 'uploads/blog', $imageName); // Simpan ke public/uploads/blog
        }

        // Simpan ke database
        $this->blogModel->save([
            'title'       => $title,
            'slug'        => $slug,
            'content'     => $content,
            'cover_image' => $imageName
        ]);

        return redirect()->to(base_url('dashboard/blog'))->with('success', 'Blog berhasil ditambahkan');
    }



    public function edit($slug)
    {
        // Ambil blog berdasarkan slug
        $blog = $this->blogModel->where('slug', $slug)->first();

        // Jika tidak ditemukan, lempar error 404
        if (!$blog) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Blog dengan slug '$slug' tidak ditemukan.");
        }

        // Kirim data ke view
        return view('admin/blog/edit', [
            'title' => 'Edit Blog',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Blog', 'url' => base_url('dashboard/blog')],
                ['label' => 'Edit']
            ],
            'blog' => $blog
        ]);
    }




    public function update($id)
    {
        $data = $this->request->getPost();
        $slug = url_title($data['title'], '-', true);

        $blog = $this->blogModel->find($id);
        if (!$blog) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Blog tidak ditemukan');
        }

        // Handle cover image update
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            $newImageName = $coverImage->getRandomName();
            $coverImage->move('uploads/blog/', $newImageName);
            $data['cover_image'] = $newImageName;
        } else {
            unset($data['cover_image']); // Don't overwrite if no new image
        }

        $data['slug'] = $slug;

        $this->blogModel->update($id, $data);

        return redirect()->to('dashboard/blog')->with('success', 'Blog berhasil diperbarui');
    }

    public function delete($id)
    {
        $blog = $this->blogModel->find($id);
        if (!$blog) {
            return redirect()->to('/blog')->with('error', 'Blog tidak ditemukan');
        }

        // Optional: delete image file
        if (!empty($blog['cover_image']) && file_exists('uploads/' . $blog['cover_image'])) {
            unlink('uploads/' . $blog['cover_image']);
        }

        $this->blogModel->delete($id);
        return redirect()->to('/blog')->with('success', 'Blog berhasil dihapus');
    }
}
