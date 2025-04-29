<?php

use App\Models\User;
use App\Models\Design;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Livewire\Designs\DesignIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Requests\RequestIndex;
use App\Livewire\Customers\CustomerIndex;
use App\Livewire\Categories\CategoryIndex;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DesignRequestController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


Route::get('/', function () {
    $designs = Design::all();
    return view('welcome', compact('designs'));
});

Route::get('/generate', function () {

    $categories = Category::get();
    return view('generate', compact('categories'));
});



Route::get('/about-us', function () {
    return view('about_us');
})->name('about_us');



Route::get('/generate-design', action: function (Request $request) {
    // Get request parameters
    $floors = $request->input('floors');
    $rooms = $request->input('rooms');
    $marla = $request->input('marla');
    $category = $request->input('category');
    
    // First, check if a similar design already exists in the database
    $existingDesign = Design::where('marla', $marla)
                            ->where('no_of_rooms', $rooms)
                            ->where('no_of_floors', $floors)
                            ->first();
    
    // If a similar design exists, use its thumbnail
    if ($existingDesign && $existingDesign->thumbnail) {
        $apiResult = [
            'success' => true,
            'image' => Storage::url($existingDesign->thumbnail),
            'from_database' => true,
            'design_id' => $existingDesign->id
        ];
        
        \Log::info('Using existing design from database:', ['design_id' => $existingDesign->id]);
    } else {
        // If no similar design exists, call the external API
        try {
            $apiPayload = [
                'house_type' => $category ?: 'modern',
                'num_marla' => (int)$marla ?: 0,
                'num_floors' => (int)$floors ?: 0,
                'num_bedrooms' => (int)$rooms ?: 0,
                'additional_preferences' => []
            ];
            
            // Call the external API with timeout configuration
            $response = Http::timeout(70)->retry(3, 100)->post('http://18.212.147.42:8000/api/v1/generate-house-image', $apiPayload);
            $apiResult = $response->json();
            
            // Add a flag to indicate this came from the external API
            $apiResult['from_database'] = false;
            
            \Log::info('API Response:', ['status' => $response->status(), 'data' => isset($apiResult['image']) ? 'Image received' : 'No image in response']);
        } catch (\Exception $e) {
            \Log::error('API Error:', ['message' => $e->getMessage()]);
            $apiResult = [
                'error' => 'Failed to generate image. Please try again.',
                'from_database' => false
            ];
        }
    }
    
    // Get any other designs that might be relevant for display
    $designs = Design::take(8)->latest()->get();

    return view('generate-design', compact('designs', 'apiResult'));
});

Route::get('wishlist', function () {
  
    $designs = Wishlist::with('design')  
        ->where('user_id', auth()->user()->id)
        ->get();

    return view('my_wishlist', compact('designs'));
})->name('my_wishlist');


Route::get('/design-detail/{id}', function ($id) {
    $design = Design::find($id);
    $userPayment = Payment::where('customer_id', Auth::id())->first();
    return view('design_detail', compact('design','userPayment'));
})->name('design.detail');


Route::post('wishlist/add/{id}', function (Request $request) {
    $existingWishlistItem = Wishlist::where('user_id', Auth::id())
        ->where('design_id', $request->design_id)
        ->first();

    if ($existingWishlistItem) {
        return response()->json(['success' => false, 'message' => 'This design is already in your wishlist.']);
    }

    Wishlist::insert([
        'user_id' => Auth::id(),
        'design_id' => $request->design_id,
    ]);

    return response()->json(['success' => true, 'message' => 'Design added to wishlist!']);
})->name('wishlist.add');


Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');



Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {


    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/customers', CustomerIndex::class)->name('customers.index');
    Route::get('/designs', DesignIndex::class)->name('designs.index');

    Route::get('/requests', RequestIndex::class)->name('requests.index');

});

Route::post('/designs/request', [DesignRequestController::class, 'store'])->name('designs.request.store');


Route::get('/dashboard', function () {
    $categoryCount = Category::count();
    $designCount = Design::count();
    $customerCount = User::where('role','customer')->count();
    return view('dashboard', compact('categoryCount','designCount', 'customerCount' ));
})->middleware(['auth', 'role:admin'])->name('dashboard');

Route::get('/notAllowed', function () {
    return view('notAllowed');
})->name('notAllowed');

Route::get('/debug-storage', function () {
    return view('debug-storage');
})->name('debug.storage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
