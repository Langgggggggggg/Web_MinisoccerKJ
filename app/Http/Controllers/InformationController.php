<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Informasi::latest()->get();
        return view('admin.information.index', compact('informations'));
    }
    public function publicIndex()
    {
        $informations = Informasi::latest()->get();
        return view('landing_page.information.index', compact('informations'));
    }
    public function show($slug)
    {
        $information = Informasi::where('slug', $slug)->firstOrFail();

        return view('landing_page.information.show', compact('information'));
    }

    public function create()
    {
        return view('admin.information.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Tambahkan slug unik
        $slug = Str::slug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Informasi::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('informations', 'public');
        }

        Informasi::create($data);
        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil ditambahkan.');
    }


    public function update(Request $request, Informasi $information)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika judul berubah, perbarui slug juga
        if ($data['title'] !== $information->title) {
            $slug = Str::slug($data['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (Informasi::where('slug', $slug)->where('id', '!=', $information->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            if ($information->thumbnail) {
                Storage::disk('public')->delete($information->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('informations', 'public');
        }

        $information->update($data);
        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil diperbarui.');
    }


    public function edit(Informasi $information)
    {
        return view('admin.information.edit', compact('information'));
    }
    public function destroy(Informasi $information)
    {
        Storage::disk('public')->delete($information->thumbnail);
        $information->delete();
        return back()->with('success', 'Informasi berhasil dihapus.');
    }
}
