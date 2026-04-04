<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function createSell()
    {
        return view('vendor.item_form', ['type' => 'sell']);
    }

    public function createRent()
    {
        return view('vendor.item_form', ['type' => 'rent']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:sell,rent',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:100',
            'location_text' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'images.*' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:5',
        ]);

        $itemData = $request->except('images');
        $itemData['user_id'] = auth()->id();

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('items', 'public');
            }
        }
        $itemData['image_path'] = count($imagePaths) > 0 ? $imagePaths : null;  

        Item::create($itemData);

        $message = $request->type == 'sell' ? 'Item listed for sale successfully!' : 'Item listed for rent successfully!';
        return redirect()->route('vendor.services')->with('success', $message);
    }

    public function edit(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }
        return view('vendor.item_form', ['type' => $item->type, 'item' => $item]);
    }

    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:sell,rent',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:100',
            'location_text' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'images.*' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:5',
        ]);

        $itemData = $request->except('images');

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('items', 'public');
            }
            $itemData['image_path'] = count($imagePaths) > 0 ? $imagePaths : null;
        }

        $item->update($itemData);

        return redirect()->route('vendor.services')->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }
        $item->delete();
        return redirect()->route('vendor.services')->with('success', 'Item deleted successfully!');
    }
}

