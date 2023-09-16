<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileRequest $request)
    {
        try {
            $user = Auth()->user();
            $request['user_id'] = $user->id;
            $data = $request->all();

            $profile = Profile::create($data);

            if ($profile) {
                return redirect()->route('profile.edit', $profile);
            } else {
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        try {
            $profile->update($request->all());
            return redirect()->back()->with('info', [ 'color' => 'success', 'texto' =>'Todo bien']);
        } catch (\Exception $e) {
            return redirect()->back()->with('info', [ 'color' => 'danger', 'texto' =>'Todo mal']);;
        }
    }
}
