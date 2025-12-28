<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'username',
        'password_hash',
        'role',
        'nama_lengkap',
        'email',
        'phone',
        'nik',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[4]|max_length[50]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
        'role' => 'required|in_list[admin,bendahara,sekretaris,koordinator_keamanan,anggota_ronda,warga]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'nik' => 'permit_empty|exact_length[16]|numeric',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi',
            'is_unique' => 'Username sudah digunakan',
        ],
        'role' => [
            'required' => 'Role harus dipilih',
            'in_list' => 'Role tidak valid',
        ],
        'nama_lengkap' => [
            'required' => 'Nama lengkap harus diisi',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Verify user credentials
     */
    public function verifyCredentials(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)
                     ->where('is_active', 1)
                     ->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Remove password from returned data
            unset($user['password_hash']);
            return $user;
        }

        return null;
    }

    /**
     * Create new user with hashed password
     */
    public function createUser(array $data): bool
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        return $this->insert($data);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        return $this->update($userId, [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $role): array
    {
        return $this->where('role', $role)
                    ->where('is_active', 1)
                    ->findAll();
    }
}
