<?php

namespace App\Controllers;

use App\Models\MenuItemModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Menu extends BaseController
{
    protected MenuItemModel $menuItemModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->menuItemModel = new MenuItemModel();
        $this->categoryModel = new CategoryModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $filterName = $this->request->getGet('name');
        $filterStatus = $this->request->getGet('status');
        $filterCategory = $this->request->getGet('category');

        $query = $this->menuItemModel;

        if ($filterName) {
            $query->like('name', $filterName);
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterCategory) {
            $query->where('category_id', $filterCategory);
        }

        $menuItems = $query->findAll();
        $allCategories = $this->categoryModel->findAll();
        $categoryMap = [];

        foreach ($allCategories as $cat) {
            $categoryMap[$cat['id']] = $cat['name'];
        }

        return view('admin/menu_list_view', [
            'page_title' => 'Menu Items',
            'menuItems' => $menuItems,
            'allCategories' => $allCategories,
            'categoryMap' => $categoryMap,
            'filterName' => $filterName,
            'filterStatus' => $filterStatus,
            'filterCategory' => $filterCategory,
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function new()
    {
        $categories = $this->categoryModel->findAll();

        return view('admin/menu_add_view', [
            'page_title' => 'Add Menu Item',
            'categories' => $categories,
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function create()
    {
        $rules = $this->menuItemModel->getValidationRules();

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('item_image');
        $imageName = '';

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            if ($imageFile->getSize() > 1024 * 1024) { // 1MB limit
                return redirect()->back()->withInput()->with('error', 'Image file is too large.');
            }

            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/menu_images', $imageName);
        }

        $this->menuItemModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $this->request->getPost('price'),
            'status' => $this->request->getPost('status'),
            'image' => $imageName
        ]);

        return redirect()->to(base_url('menu'))->with('message', 'Menu item added successfully.');
    }

    // ✅ DELETE function
    public function delete($id)
    {
        $item = $this->menuItemModel->find($id);

        if (!$item) {
            return redirect()->to(base_url('menu'))->with('error', 'Menu item not found.');
        }

        // Delete the image file if it exists
        if (!empty($item['image']) && file_exists('uploads/menu_images/' . $item['image'])) {
            unlink('uploads/menu_images/' . $item['image']);
        }

        $this->menuItemModel->delete($id);

        return redirect()->to(base_url('menu'))->with('message', 'Menu item deleted successfully.');
    }
}
