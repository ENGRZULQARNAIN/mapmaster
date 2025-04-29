<?php

namespace App\Livewire\Categories;

use App\Models\Category; // Ensure you have a Category model
use Livewire\Component;
use Mary\Traits\Toast;

class CategoryIndex extends Component
{

    use Toast;
    public bool $Modal = false;
    public bool $isEditMode = false;
    public $categoryId, $categoryName;
    public $search = '';
    
    public function render()
    {
        
        $categories = Category::when($this->search, function($query) {
                
            $query->where('name', 'like', '%' . $this->search . '%');
           
        })->get();
        return view('livewire.categories.category-index', compact('categories'));
    }

    // Open the modal for creating a new category
    public function openModal()
    {
        $this->resetFields();
        $this->Modal = true;
    }

    // Open the modal for editing a category
    public function edit($id)
    {
        $category = Category::find($id);
        $this->categoryId = $category->id;
        $this->categoryName = $category->name;
        $this->isEditMode = true;
        $this->Modal = true;
    }

    // Store or update category
    public function save()
    {
        $this->validate(['categoryName' => 'required|string|max:255|unique:categories,name']);

        if ($this->isEditMode) {
            $category = Category::find($this->categoryId);
            $category->name = $this->categoryName;
            $category->save();
            $this->success('Category updated successfully');
        } else {
            Category::create(['name' => $this->categoryName]);
            $this->success('Category created successfully');
        }

        $this->resetFields();
        $this->Modal = false;
    }

    // Delete category
    public function delete($id)
    {
        Category::find($id)->delete();
   
        $this->success('Category deleted successfully');
    }

    // Reset fields
    private function resetFields()
    {
        $this->categoryId = null;
        $this->categoryName = '';
        $this->isEditMode = false;
    }
}
