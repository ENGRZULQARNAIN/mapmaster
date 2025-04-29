<?php 

namespace App\Livewire\Designs;

use App\Models\Design;
use App\Models\Category; // Ensure you import the Category model
use Livewire\Component;
use Livewire\WithFileUploads;

class DesignIndex extends Component
{
    use WithFileUploads;

    public bool $Modal = false;
    public $name, $thumbnail, $marla, $no_of_rooms, $no_of_floors, $description, $type, $design_id, $category_id, $price;
    public $search = '';

    public function render()
    {
        $designs = Design::with('category') // Eager load categories
            ->when($this->search, function($query) {
                
                $query->where('name', 'like', '%' . $this->search . '%'); // Perform search query
            })
            ->get();

        $categories = Category::all(); // Fetch all categories for dropdown
        return view('livewire.designs.design-index', compact('designs', 'categories'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->Modal = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required',
            'thumbnail' => $this->design_id ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'marla' => 'required|integer',
            'no_of_rooms' => 'required|integer',
            'no_of_floors' => 'required|integer',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = null;
        if ($this->thumbnail) {
            // Check if it's a file upload object or a string path
            if (!is_string($this->thumbnail)) {
                // Store in public disk directly
                $thumbnailPath = $this->thumbnail->store('thumbnails', 'public');
                
                // Log the path for debugging
                \Log::info('Thumbnail stored at: ' . $thumbnailPath);
                \Log::info('Full URL would be: ' . \Storage::url($thumbnailPath));
            } else {
                $thumbnailPath = $this->thumbnail;
            }
        }
        
        // If editing an existing design and no new thumbnail was uploaded
        if (!$thumbnailPath && $this->design_id) {
            $design = Design::find($this->design_id);
            if ($design) {
                $thumbnailPath = $design->thumbnail;
            }
        }

        Design::updateOrCreate(
            ['id' => $this->design_id],
            [
                'name' => $this->name,
                'price' => $this->price,
                'thumbnail' => $thumbnailPath,
                'marla' => $this->marla,
                'no_of_rooms' => $this->no_of_rooms,
                'no_of_floors' => $this->no_of_floors,
                'description' => $this->description,
                'type' => $this->type,
                'category_id' => $this->category_id,
            ]
        );

        $this->resetInputFields();
        $this->Modal = false;
        session()->flash('message', 'Design saved successfully!');
    }

    public function edit($id)
    {
        $design = Design::findOrFail($id);
        $this->design_id = $design->id;
        $this->name = $design->name;
        $this->price = $design->price;
        $this->thumbnail = $design->thumbnail;
        $this->marla = $design->marla;
        $this->no_of_rooms = $design->no_of_rooms;
        $this->no_of_floors = $design->no_of_floors;
        $this->description = $design->description;
        $this->type = $design->type;
        $this->category_id = $design->category_id; // Assume you have a category_id in the designs table
        $this->Modal = true;
    }

    public function delete($id)
    {
        Design::findOrFail($id)->delete();
        session()->flash('message', 'Design deleted successfully!');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->price = '';
        $this->thumbnail = null;
        $this->marla = '';
        $this->no_of_rooms = '';
        $this->no_of_floors = '';
        $this->description = '';
        $this->type = '';
        $this->category_id = '';
        $this->design_id = null;
    }

    public function modalClose(){
        $this->Modal = false;
    }
}
