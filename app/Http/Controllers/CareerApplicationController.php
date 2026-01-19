<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerApplication;
use Illuminate\Support\Str;

class CareerApplicationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'position' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'linkedin' => 'nullable|url|max:1000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'statement' => 'nullable|string',
            'start-date' => 'nullable|date',
        ]);

        // handle resume upload
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $name = Str::slug($request->input('name', 'applicant')) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $resumePath = $file->storeAs('resumes', $name, 'public');
        }

        $application = CareerApplication::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'position' => $data['position'],
            'location' => $data['location'],
            'linkedin' => $data['linkedin'] ?? null,
            'resume_path' => $resumePath,
            'statement' => $data['statement'] ?? null,
            'start_date' => $data['start-date'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully.');
    }
}
