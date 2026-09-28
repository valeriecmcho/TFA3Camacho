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
        'full_name',
        'avatar',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'avatar' => 'permit_empty|max_length[255]'
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters',
            'max_length' => 'Username cannot exceed 50 characters'
        ],
        'full_name' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 3 characters',
            'max_length' => 'Full name cannot exceed 100 characters'
        ],
        'avatar' => [
            'max_length' => 'Avatar filename cannot exceed 255 characters'
        ]
    ];
    protected $skipValidation = false;
}
