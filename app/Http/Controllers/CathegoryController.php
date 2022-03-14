<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Cathegory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Request;

class CathegoryController extends Controller
{
    public function index()
    {
        // $cathegories = Cathegory::with('subcathegories', 'servicesdb', 'itemsdb')->paginate(10);

        $queryCathegory=Cathegory::query();

        $cathegories = $queryCathegory->paginate(10)->through(fn($cathegory) => [
            'id' => $cathegory->id,
            'name' => $cathegory->name,
            'photo_path' => $cathegory->photo_path,
            'fillable' => $cathegory->fillable,
            'subcathegories' => $cathegory->subcathegories,
            'servicesdb' => $cathegory->servicesdb,
            'itemsdb' => $cathegory->itemsdb,
        ]);
        
        return Inertia::render('cathegories', ['data' => $cathegories]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Cathegory::class);

        $request->parent == -1 ?
            $parent = NULL : $parent = $request->parent;

        $request->validate([
            'name' => ['unique:cathegories', 'required', 'string', 'min:3', 'max:32'],
            'fillable' => 'required'
        ]);

        Cathegory::create(
            [
                'name' => $request->name,
                'cathegory_id' => $parent,
                'fillable' => $request->fillable
            ]
        );
        

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Request $request, Cathegory $cathegory)
    {
        $this->authorize('update', $cathegory, Cathegory::class);

        $request->parent == -1 ?
            $parent = NULL : $parent = $request->parent;

        $cathegory->update(
            [
                $request->validate([
                    'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id)),],
                    'fillable' => 'required'
                ]),
                'name' => $request->name,
                'cathegory_id' => $parent,
                'fillable' => $request->fillable
            ]

        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(Cathegory $cathegory)
    {
        $this->authorize('delete', $cathegory, Cathegory::class);

        $photoName = ltrim($cathegory->photo_path, '/images/');
        if ($photoName != 'default.png') 
            unlink(public_path('images') . '/' . $photoName);     

        $cathegory->delete();

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function deletePhoto($id)
    {
        $this->authorize('update', Cathegory::find($id), Cathegory::class);

        $cathegory = Cathegory::find($id);
        $photoName = ltrim($cathegory->photo_path, '/images/');

        if ($photoName != 'default.png') {
            unlink(public_path('images') . '/' . $photoName);
            $cathegory->photo_path = '/images/default.png';
            $cathegory->save();
        }

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function insertPhoto(Request $request, $id)
    {
        $this->authorize('update', Cathegory::find($id), Cathegory::class);

        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $cathegory = Cathegory::find($id);
        $photoName = ltrim($cathegory->photo_path, '/images/');
        if ($photoName != 'default.png')
            unlink(public_path('images') . '/' . $photoName);

        $imageName = time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('images'), $imageName);
        $cathegory->photo_path = '/images/' . $imageName;
        $cathegory->save();

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
