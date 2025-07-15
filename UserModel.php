<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'status'];
    protected $returnType = 'array'; // Or 'object' if you prefer

    // Automatically hash passwords before inserting or updating
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Get a user by username
     * @param string $username
     * @return array|null
     */
    public function getUserByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Update user status
     * @param int $userId
     * @param string $status ('pending', 'approved', 'rejected')
     * @return bool
     */
    public function updateUserStatus(int $userId, string $status)
    {
        return $this->update($userId, ['status' => $status]);
    }

    /**
     * Get all pending cashier accounts
     * @return array
     */
    public function getPendingCashiers()
    {
        return $this->where('role', 'cashier')
            ->where('status', 'pending')
            ->findAll();
    }

    /**
     * Get all approved cashier accounts
     * @return array
     */
    public function getApprovedCashiers()
    {
        return $this->where('role', 'cashier')
            ->where('status', 'approved')
            ->findAll();
    }
}