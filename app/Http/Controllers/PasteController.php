<?php

namespace App\Http\Controllers;
use App\Models\Paste;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PasteController extends Controller {
    public function index() {
        return Inertia::render('Pastes/Index', [
            'pastes' => Paste::latest()
                ->select(['id', 'title', 'content', 'slug', 'views', 'user_id', 'created_at', 'expiration_date'])
                ->limit(20)
                ->get()
        ]);
    }

    public function create() {
        return Inertia::render('Pastes/Create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'expiration_date' => 'nullable|date_format:Y-m-d',
        ]);

        $paste = Paste::create($validated);

        // If it's an AJAX request from the index page, return the paste data
        if ($request->expectsJson()) {
            return response()->json([
                'slug' => $paste->slug,
                'paste' => $paste
            ]);
        }

        return redirect("/pastes/{$paste->slug}");
    }

    public function show($slug) {
        $paste = Paste::where('slug', $slug)->firstOrFail();
        $paste->increment('views');
        return Inertia::render('Pastes/Show', [
            'paste' => $paste
        ]);
    }

    public function destroy($slug) {
        $paste = Paste::where('slug', $slug)->firstOrFail();
        $this->authorize('delete', $paste);
        $paste->delete();

        return redirect('/');
    }
}