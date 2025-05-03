<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BloodTypeController extends Controller
{
    public function addBloodType(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:10|unique:blood_types,name',
        ]);

        BloodType::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->back()
            ->with('success', "Le groupe sanguin '{$request->input('name')}' a été ajouté avec succès.");
    }

    public function updateBloodType(Request $request, $id)
    {
        $bloodType = BloodType::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required|string|max:10|unique:blood_types,name,' . $id,
        ]);

        $bloodType->name = $request->name;
        $bloodType->save();
        return redirect()->back()
            ->with('success', "Le groupe sanguin '{$bloodType->name}' a été mis à jour avec succès.");
    }

    public function deleteBloodType($id)
    {
        $bloodType = BloodType::findOrFail($id);
        $bloodTypeName = $bloodType->name;

        if ($bloodType->donors()->count() > 0) {
            return redirect()->route('admin.data')
                ->with('error', "Impossible de supprimer le groupe sanguin '{$bloodTypeName}' car il est associé à des donneurs.");
        }

        $bloodType->delete();

        return redirect()->route('admin.data')
            ->with('success', "Le groupe sanguin '{$bloodTypeName}' a été supprimé avec succès.");
    }
}
