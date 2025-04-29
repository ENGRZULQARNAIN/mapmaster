<?php

namespace App\Livewire\Requests;

use Mary\Traits\Toast;
use App\Models\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestIndex extends Component
{
    use WithFileUploads;
    use Toast;

    public $newDesign = [];

    public function render()
    {
        $requests = Request::with(['user', 'design'])->orderBy('id', 'desc')->paginate(10);
        return view('livewire.requests.request-index', compact('requests'));
    }

    public function update($requestId)
    {
        $requestModel = Request::findOrFail($requestId);

        // Handle file upload if a new design file is uploaded
        if (isset($this->newDesign[$requestId])) {
            // Validate the uploaded file
            $this->validate([
                'newDesign.' . $requestId => 'file|mimes:jpg,png,jpeg|max:1024', // Adjust MIME types and file size as needed
            ]);

            // Store the file and update the design thumbnail
            $path = $this->newDesign[$requestId]->store('designs', 'public');
            $requestModel->design_file = $path;
           
            $requestModel->status = 1;
            $requestModel->save();

            $this->success('Request updated and approved successfully!');
        } else {
            // Toggle the request status if no new file is uploaded
            $requestModel->status = !$requestModel->status;
            $requestModel->save();

            $this->success( 'Request status updated successfully!');
        }
    }
}
