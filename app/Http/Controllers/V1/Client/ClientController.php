<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Client\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('client.clients')->with('clients', Client::paginate(10));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $request->validated();

        $name = now()->timestamp.".{$request->photo->getClientOriginalName()}";
        $path = $request->file('photo')->storeAs('files', $name, 'public');

        Client::create([
            'first_name' => $request->first_name,
            'last_name'=> $request->last_name,
            'username' => $request->username,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'phone'=> $request->phone,
            'company_name'=> $request->company_name,
            'position'=> $request->position,
            'photo'=> "/storage/$path"
        ]);

            

        return back()->with('Add','Client Record has been created successfully !');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('client.edit_client')->with( 'client' , $client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $client = Client::findOrFail($id);
        $oldPhotoPath = $client->photo;

        if ($request->hasFile('photo')) {
            $name = now()->timestamp.".{$request->photo->getClientOriginalName()}";
             $path = $request->file('photo')->storeAs('files', $name, 'public');

            // Delete the user's old photo file from the storage location
            if ($oldPhotoPath !== null) {

                Storage::delete($oldPhotoPath);
            }

            // Update the user's photo path in the database to the new file path
            $client->photo = "/storage/$path";
            $client->save();
        }
        else {
            $client->photo = $oldPhotoPath;
            $client->save();
        }

        $update = [
            'first_name' => $request->first_name,
            'last_name'=> $request->last_name,
            'username' => $request->username,
            'phone'=> $request->phone,
            'company_name'=> $request->company_name,
            'position'=> $request->position,

        ];
        Client::where('id', $id)->update($update);
        $msg = "Client Updated successful! ";
        return back()->with('update', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
