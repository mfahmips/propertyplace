<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;
use CodeIgniter\Shield\Authentication\Passwords\Password;
use RuntimeException;

class User extends ShieldUser
{
    protected $datamap = [];

    protected $dates = ['reset_at', 'reset_expires', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'username'         => 'string',
        'email'            => 'string',
        'active'           => 'boolean',
        'force_pass_reset' => 'boolean',
    ];

    protected $permissions = [];
    protected $roles       = [];

    /**
     * Hash password dan bersihkan reset token
     */
    public function setPassword(string $password): static
    {
        $this->attributes['password_hash'] = Password::hash($password);

        $this->attributes['reset_hash']    = null;
        $this->attributes['reset_at']      = null;
        $this->attributes['reset_expires'] = null;

        return $this;
    }

    public function setActive($active): void
    {
        $this->attributes['active'] = $active ? 1 : 0;
    }

    public function setForcePassReset($force_pass_reset): void
    {
        $this->attributes['force_pass_reset'] = $force_pass_reset ? 1 : 0;
    }

    /**
     * Paksa reset password di login berikutnya
     */
    public function forcePasswordReset(): void
    {
        $this->generateResetHash();
        $this->attributes['force_pass_reset'] = 1;
    }

    public function generateResetHash(): static
    {
        $this->attributes['reset_hash']    = bin2hex(random_bytes(16));
        $this->attributes['reset_expires'] = date('Y-m-d H:i:s', time() + config('Auth')->magicLink()->lifetime);

        return $this;
    }

    public function generateActivateHash(): static
    {
        $this->attributes['activate_hash'] = bin2hex(random_bytes(16));

        return $this;
    }

    public function activate(): void
    {
        $this->attributes['active']        = 1;
        $this->attributes['activate_hash'] = null;
    }

    public function deactivate(): void
    {
        $this->attributes['active'] = 0;
    }

    public function isActivated(): bool
    {
        return $this->active;
    }

    public function ban(?string $message = null): static
    {
        $this->attributes['status']         = 'banned';
        $this->attributes['status_message'] = $message ?? '';

        return $this;
    }

    public function unBan(): static
    {
        $this->attributes['status']         = '';
        $this->attributes['status_message'] = '';

        return $this;
    }

    public function isBanned(): bool
    {
        return isset($this->attributes['status']) && $this->attributes['status'] === 'banned';
    }

    public function can(string ...$permissions): bool
    {
        $userPermissions = $this->getPermissions() ?? [];

        foreach ($permissions as $permission) {
            if (in_array(strtolower($permission), $userPermissions, true)) {
                return true;
            }
        }

        return false;
    }

    public function getPermissions(): ?array
    {
        if (empty($this->id)) {
            throw new RuntimeException('Users must be created before getting permissions.');
        }

        if (empty($this->permissions)) {
            $this->permissions = model(\CodeIgniter\Shield\Models\PermissionModel::class)->getPermissionsForUser($this->id);
        }

        return $this->permissions;
    }

    public function getRoles(): array
    {
        if (empty($this->id)) {
            throw new RuntimeException('Users must be created before getting roles.');
        }

        if (empty($this->roles)) {
            $groups = model(\CodeIgniter\Shield\Models\GroupModel::class)->getGroupsForUser($this->id);

            foreach ($groups as $group) {
                $this->roles[$group['group_id']] = strtolower($group['name']);
            }
        }

        return $this->roles;
    }

    public function setPermissions(?array $permissions = null): void
    {
        throw new RuntimeException('User entity does not support saving permissions directly.');
    }
}
