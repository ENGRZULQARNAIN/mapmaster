<?php

namespace App\Livewire\Customers;

use App\Models\Payment;
use App\Models\User;
use Livewire\Component;
use Mary\Traits\Toast;

class CustomerIndex extends Component
{
    use Toast;
    public $showDrawer = false;
    public $selectedOrder;
    public $search = '';
    public function render()
    {
        $customers = User::where('role','customer')
        ->when($this->search, function($query) {
                
            $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id','desc')
        ->get();
        return view('livewire.customers.customer-index', compact('customers'));
    }

    public function delete($id)
    {
        User::find($id)->delete();
   
        $this->success('User deleted successfully');
    }

    public function confirDelete($id)
    {
        // Call the delete method directly
        $this->delete($id);
    }
    
    public function showPaymentDetails($paymentId)
    {
        $this->selectedOrder = Payment::find($paymentId);
        $this->showDrawer = true;
    }

    public function statusChange($paymentId, $status)
    {
        $payment = Payment::find($paymentId);
        if ($payment) {
            $payment->status = $status;
            $payment->save();
        }
        $this->success('Payment updated successfully');
        $this->showDrawer = false;
    }
}
