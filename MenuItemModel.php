<?php namespace App\Models;

use CodeIgniter\Model;

class MenuItemModel extends Model
{
    protected $table      = 'menu_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType         = 'array';
    protected $useSoftDeletes     = false;

    protected $allowedFields = [
        'name',
        'description',
        'category_id',
        'price',
        'status',
        'image'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'price' => 'required|numeric|greater_than[0]',
        'status' => 'required|in_list[available,unavailable]',
        'description' => 'permit_empty|max_length[1000]',
        'image' => 'permit_empty|max_length[255]',
        'category_id' => 'permit_empty|integer|is_not_unique[categories.id]'
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Menu item name is required.',
            'min_length' => 'Menu item name must be at least 3 characters long.',
            'max_length' => 'Menu item name cannot exceed 255 characters.'
        ],
        'price' => [
            'required'     => 'Price is required.',
            'numeric'      => 'Price must be a number.',
            'greater_than' => 'Price must be greater than zero.'
        ],
        'status' => [
            'required' => 'Status is required.',
            'in_list'  => 'Invalid status. Must be available or unavailable.'
        ],
        'category_id' => [
            'integer'   => 'Invalid category selection.',
            'in_table'  => 'Selected category does not exist.'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters.'
        ],
        'image' => [
            'max_length' => 'Image path cannot exceed 255 characters.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
