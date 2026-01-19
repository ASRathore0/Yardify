<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CareerApplication;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    /**
     * Show the careers application form.
     */
    public function show()
    {
        return view('careers.apply');
    }

    /**
     * Handle submission of the careers application form.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'position' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'linkedin' => 'nullable|url|max:1024',
            'statement' => 'required|string',
            'start_date' => 'required|date',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $name = Str::slug($validated['name'] ?? 'applicant') . '-' . time() . '.' . $file->getClientOriginalExtension();
            $resumePath = $file->storeAs('resumes', $name, 'public');
        }

        CareerApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'location' => $validated['location'],
            'linkedin' => $validated['linkedin'] ?? null,
            'statement' => $validated['statement'],
            'start_date' => $validated['start_date'],
            'resume_path' => $resumePath,
        ]);

        return redirect()->route('careers.show')->with('success', 'Application submitted successfully. Thank you!');
    }
}
