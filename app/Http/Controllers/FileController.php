<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve the files associated with the current logged-in user
        $files = File::where('user_id', Auth::id())->get();

        return view('files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function download(File $file)
    {
        // Retrieve the file path from the database
        $filePath = $file->path;

        // Check if the file exists
        if (!Storage::exists($filePath)) {
            // Handle scenario where file doesn't exist
            return response()->json(['error' => 'File not found'], Response::HTTP_NOT_FOUND);
        }

        // Return a response to initiate the file download
        return Storage::download($filePath);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // Adjust the max file size as needed
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->timestamp;

        // Construct the new file name with timestamp
        $newFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

        // Store the file
        $filePath = $file->storeAs('uploads', $newFileName);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Save the file details to the database
        $fileModel = new File();
        $fileModel->user_id = $userId;
        $fileModel->filename = $fileName;
        $fileModel->path = $filePath;
        $fileModel->save();


        return redirect()->route('files.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {

        Storage::delete($file->path);

        // Delete the file record from the database
        $file->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
