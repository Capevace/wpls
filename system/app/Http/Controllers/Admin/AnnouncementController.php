<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Gets all Announcements and returns them as json.
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $announcements = Announcement::all();

        return response()->json($announcements);
    }

    public function get(Announcement $announcement)
    {
        return response()->json($announcement);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title'    => 'required|string',
            'content'  => 'required|string',
            'type'     => 'required|string|max:16|in:' . implode(',', Announcement::$availableTypes),
            'packages' => 'array'
        ]);

        $announcement          = new Announcement;
        $announcement->title   = $validatedData['title'];
        $announcement->content = $validatedData['content'];
        $announcement->type    = $validatedData['type'];

        $announcement->save();
        
        if (array_key_exists('packages', $validatedData)) {
            $announcement->packages()->attach($validatedData['packages']);
        }

        return response()->json($announcement->packages()->get());
    }

    public function delete(Announcement $announcement)
    {
        $announcement->delete();

        return response(200, 200);
    }
}
