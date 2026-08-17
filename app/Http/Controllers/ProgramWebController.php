<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;

class ProgramWebController extends Controller
{

    public function index()
    {
        $programs = Program::with('category')->latest()->paginate(15);
        return view('program.index', compact('programs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('program.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:programs,slug',
            'description' => 'required',
            'target'      => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
            'deadline'    => 'nullable|date',
            'distribution_date' => 'nullable|date',
            'distribution_photos.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'slug', 'description', 'target_amount', 'category_id', 'deadline', 'is_active', 'distribution_date']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        if ($request->hasFile('distribution_photos')) {
            $photos = [];
            foreach ($request->file('distribution_photos') as $photo) {
                $photos[] = $photo->store('programs/distribution', 'public');
            }
            $data['distribution_photos'] = $photos;
        }

        Program::create($data);

        return redirect()->route('program.index')->with('status', 'Program berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        $categories = Category::all();
        return view('program.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:programs,slug,' . $program->id,
            'description' => 'required',
            'target'      => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
            'deadline'    => 'nullable|date',
            'distribution_date' => 'nullable|date',
            'distribution_photos.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'slug', 'description', 'target_amount', 'category_id', 'deadline', 'distribution_date']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        if ($request->hasFile('distribution_photos')) {
            $photos = $program->distribution_photos ?? [];
            foreach ($request->file('distribution_photos') as $photo) {
                $photos[] = $photo->store('programs/distribution', 'public');
            }
            $data['distribution_photos'] = $photos;
        }

        $program->update($data);

        return redirect()->route('program.index')->with('status', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('program.index')->with('status', 'Program berhasil dihapus.');
    }
}
