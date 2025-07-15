<?php namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class CategoryController extends BaseController
{
    protected CategoryModel $categoryModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        return view('admin/categories', [
            'page_title' => 'Category Management',
            'categories' => $this->categoryModel->findAll(),  // no ordering → oldest first, newest last
            'success'    => session()->getFlashdata('success'),
            'error'      => session()->getFlashdata('error'),
            'errors'     => session()->getFlashdata('errors'),
        ]);
    }


    public function store()
    {
        $post = $this->request->getPost();
        if ($this->categoryModel->insert(['name' => $post['name']])) {
            return redirect()->to('/categories')->with('success', 'Category added successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to add category.')
            ->with('errors', $this->categoryModel->errors());
    }


    public function edit(int $id = null)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Category not found.');
        }

        return view('admin/category_edit', [
            'page_title' => 'Edit Category',
            'category'   => $category,
            'validation' => session()->getFlashdata('errors'),
        ]);
    }

    public function update(int $id = null)
    {
        $post = $this->request->getPost();
        $this->categoryModel->setValidationRule('name', "required|min_length[3]|max_length[255]|is_unique[categories.name,id,{$id}]");

        if (!$this->categoryModel->update($id, ['name' => $post['name']])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update category.')
                ->with('errors', $this->categoryModel->errors());
        }

        return redirect()->to('/categories')->with('success', 'Category updated successfully.');
    }

    public function delete(int $id = null)
    {
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/categories')->with('success', 'Category deleted.');
        }

        return redirect()->to('/categories')->with('error', 'Failed to delete category.');
    }
}
