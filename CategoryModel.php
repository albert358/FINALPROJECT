<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]|is_unique[categories.name]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Category name is required.',
            'min_length' => 'Category name must be at least 3 characters long.',
            'max_length' => 'Category name cannot exceed 255 characters.',
            'is_unique'  => 'This category name already exists.'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}