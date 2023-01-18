<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        foreach (Chirp::all() as $chirp) {
            if ($chirp->caducable == 1) {
                $a = $chirp->created_at;
                $a = $a->diffInSeconds(now());
                if ($a >= 10) {
                    $chirp->delete();
                }
            }
        }
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comentable = $request->input('comentable');
        if ($comentable == 1) {
            $request->request->add(['comentable' => true]);
        } else {
            $request->request->add(['comentable' => false]);
        }

        $caducable = $request->input('caducable');
        if ($caducable == 1) {
            $request->request->add(['caducable' => true]);
        } else {
            $request->request->add(['caducable' => false]);
        }

        $visibilitat = $request->input('visibilitat');
        if($visibilitat == 1){
            $request->request->add(['visibilitat' => true]);
        } else {
            $request->request->add(['visibilitat' => false]);
        }


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'extract' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'comentable' => 'required',
            'caducable' => 'required',
            'visibilitat' => 'required',
        ]);

        
 
        $request->user()->chirps()->create($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
 
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'title' => 'required|string|max:55',
            'extract' => 'required|string|max:55',
            'message' => 'required|string|max:255',
            'comentable' => 'required',
            'caducable' => 'required',
            'visibilitat' => 'required',
        ]);

 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
