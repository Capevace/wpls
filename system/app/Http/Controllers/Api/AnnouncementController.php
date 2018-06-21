<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiRequest;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function newest(ApiRequest $request)
    {
        $validatedData = $request->validate([
            'after' => 'required|date'
        ]);
    
        $announcements = Announcement::where('created_at', '>=', $validatedData['after'])
            ->with('packages:packages.id,packages.slug,packages.name')
            ->get();

        return response()->json($announcements);
    }
}
