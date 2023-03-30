<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function index()
    {
        //get posts
        $songs = Song::latest()->paginate(5);

        //render view with posts
        return view('index', compact('songs'));
    }

    public function create()
    {
        return view ('create');
    }

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'title'     => 'required|min:1',
            'singer'    => 'required|min:5',
            'release'   => 'required|min:1'
        ]);

        //create post
        Song::create([
            'title'     => $request->title,
            'singer'    => $request->singer,
            'release'   => $request->release
        ]);

        //redirect to index
        return redirect()->route('songs.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Song $song)
    {
        return view('edit', compact('song'));
    }

    public function update(Request $request, Song $song)
    {
        //validate form
        $this->validate($request, [
            'title'     => 'required|min:1',
            'singer'    => 'required|min:5',
            'release'   => 'required|min:1'
        ]);

        //update post without image
        $song->update([
            'title'     => $request->title,
            'singer'    => $request->singer,
            'release'   => $request->release
        ]);

        //redirect to index
        return redirect()->route('songs.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Song $song)
    {
        //delete image
        Storage::delete('public/songs/'. $song->image);

        //delete post
        $song->delete();

        //redirect to index
        return redirect()->route('songs.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
