<?php

namespace App\Controllers;

use App\Models\UserModel;
use League\OAuth2\Client\Provider\Google;

class AuthGoogle extends BaseController
{
    public function redirect()
    {
        $provider = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => base_url('auth/google/callback'),
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        session()->set('oauth2state', $provider->getState());
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $provider = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => base_url('auth/google/callback'),
        ]);

        if ($this->request->getGet('state') !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            exit('Invalid state');
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $this->request->getGet('code')
        ]);

        $googleUser = $provider->getResourceOwner($token);
        $email      = $googleUser->getEmail();
        $name       = $googleUser->getName();

        // Cek dan buat user
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            $userModel->save([
                'name'      => $name,
                'email'     => $email,
                'slug'      => url_title($name, '-', true),
                'password'  => password_hash(bin2hex(random_bytes(5)), PASSWORD_DEFAULT),
                'role'      => 'customer',
                'is_active' => 1
            ]);
            $user = $userModel->where('email', $email)->first();
        }

        // Simpan session
        session()->set('is_logged_in', true);
        session()->set('user', $user);

        return redirect()->to('/dashboard');
    }
}
