<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;
use App\Models\SettingsModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['number'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load SettingsModel dan ambil 1 baris data settings
        $settingsModel = new \App\Models\SettingsModel();
        $settings = $settingsModel->first(); // karena hanya 1 baris

        // Kirim ke semua view
        $renderer = \Config\Services::renderer();
        $renderer->setData([
            'settings' => $settings,
            'about'    => $settings['about'] ?? '',
            'tagline'    => $settings['tagline'] ?? '',
            'location'  => $settings['location'] ?? '',
            'phone'     => $settings['phone'] ?? '',
            'instagram' => $settings['instagram'] ?? '',
            'tiktok'    => $settings['tiktok'] ?? '',
        ]);
    }



    protected function requireLogin()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login');
        }
    }

}
