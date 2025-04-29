<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Design Requests</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">#</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Customer</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Design</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Request Description</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">New Design</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Status</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Action</th>
             </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
            <tr class="hover:bg-gray-100">
                <td class="px-6 py-4 border-b border-gray-200">{{ $request->id }}</td>
                <td class="px-6 py-4 border-b border-gray-200">{{ $request->user->name }}</td>
                <td class="px-6 py-4 border-b border-gray-200">
                    <!-- Display current design thumbnail and name -->
                    <img width="150" class="rounded" src="{{ Storage::url($request->design->thumbnail) ?? '' }}" alt="">  
                    {{ $request->design->name }}
                    <!-- File input for new design -->
                  
                </td>
                
                <td class="px-6 py-4 border-b border-gray-200">{{ $request->description }}</td>
                <td>
                    <img width="150" class="rounded" src="{{ Storage::url($request->design_file) ?? '' }}" alt="">  
                </td>
                <td class="px-6 py-4 border-b border-gray-200">
                    <!-- Display Approved or Pending status based on the request status -->
                    @if ($request->status)
                        <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-sm">Approved</span>
                    @else
                        <span class="text-red-600 bg-red-100 px-2 py-1 rounded-full text-sm">Pending</span>
                    @endif
                </td>
                <td class="px-6 py-4 border-b border-gray-200">
                    <input type="file" wire:model="newDesign.{{ $request->id }}" class="mt-2 text-sm"> <br>
                    <button wire:click="update({{ $request->id }})"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm mt-1">
                        {{-- {{ $request->status ? 'Revoke' : 'Approve' }} --}}
                        Update
                    </button>
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
    <div class="mt-4">
        {{ $requests->links() }}  
    </div>
</div>
