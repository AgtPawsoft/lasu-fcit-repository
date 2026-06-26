<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Department;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function search(Request $req)
    {
        $query = Document::approved()->with(['user', 'department', 'category']);

        if ($req->keyword) {
            $query->where(function($q) use ($req) {
                $q->where('title', 'like', '%'.$req->keyword.'%')
                  ->orWhere('abstract', 'like', '%'.$req->keyword.'%')
                  ->orWhere('keywords', 'like', '%'.$req->keyword.'%');
            });
        }
        if ($req->department_id) $query->where('department_id', $req->department_id);
        if ($req->category_id) $query->where('category_id', $req->category_id);
        if ($req->year) $query->where('publication_year', $req->year);
        if ($req->author) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%'.$req->author.'%'));
        }

        $documents = $query->latest()->paginate(10);
        $departments = Department::all();
        $categories = Category::all();
        $years = Document::approved()->distinct()->pluck('publication_year')->filter()->sort()->reverse();
        return view('documents.search', compact('documents', 'departments', 'categories', 'years'));
    }

    public function show(Document $document)
    {
        if ($document->status !== 'approved') abort(404);
        $document->load(['user', 'department', 'category', 'authors.user']);
        return view('documents.show', compact('document'));
    }

    public function create()
    {
        $departments = Department::all();
        $categories = Category::all();
        return view('documents.create', compact('departments', 'categories'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx|max:51200',
            'department_id' => 'required|exists:departments,id',
            'category_id' => 'required|exists:categories,id',
            'keywords' => 'nullable|string',
            'publication_year' => 'nullable|integer|min:1900|max:'.date('Y'),
        ]);

        $path = $req->file('file')->store('documents', 'public');
        $doc = Document::create([
            'title' => $req->title,
            'abstract' => $req->abstract,
            'file_path' => $path,
            'file_type' => $req->file('file')->getClientOriginalExtension(),
            'user_id' => auth()->id(),
            'department_id' => $req->department_id,
            'category_id' => $req->category_id,
            'keywords' => $req->keywords,
            'publication_year' => $req->publication_year,
            'status' => 'pending',
        ]);

        Author::create(['document_id' => $doc->id, 'user_id' => auth()->id(), 'is_primary' => true]);
        return redirect()->route('dashboard')->with('success', 'Document submitted successfully! Awaiting approval.');
    }

    public function download(Document $document)
    {
        if ($document->status !== 'approved') abort(404);
        return Storage::disk('public')->download($document->file_path, $document->title.'.'.$document->file_type);
    }

    public function edit(Document $document)
    {
        if ($document->user_id !== auth()->id()) abort(403);
        $departments = Department::all();
        $categories = Category::all();
        return view('documents.edit', compact('document', 'departments', 'categories'));
    }

    public function update(Request $req, Document $document)
    {
        if ($document->user_id !== auth()->id()) abort(403);
        $req->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'category_id' => 'required|exists:categories,id',
            'keywords' => 'nullable|string',
            'publication_year' => 'nullable|integer|min:1900|max:'.date('Y'),
        ]);
        $document->update($req->only(['title', 'abstract', 'department_id', 'category_id', 'keywords', 'publication_year']));
        return redirect()->route('dashboard')->with('success', 'Document updated successfully!');
    }

    public function destroy(Document $document)
    {
        if ($document->user_id !== auth()->id()) abort(403);
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return redirect()->route('dashboard')->with('success', 'Document deleted successfully!');
    }
}