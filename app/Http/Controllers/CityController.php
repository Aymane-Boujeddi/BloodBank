<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function addCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cities,name',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.data')
                ->withErrors($validator)
                ->withInput();
        }

        $city = new City();
        $city->name = $request->input('name');
        $city->save();

        return redirect()->route('admin.data')
            ->with('success', "La ville '{$city->name}' a été ajoutée avec succès.");
    }

    public function updateCity(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cities,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.data')
                ->withErrors($validator)
                ->withInput();
        }

        $oldName = $city->name;
        $city->name = $request->input('name');
        $city->save();

        return redirect()->route('admin.data')
            ->with('success', "La ville '{$oldName}' a été modifiée en '{$city->name}' avec succès.");
    }

    public function deleteCity($id)
    {
        $city = City::findOrFail($id);
        $cityName = $city->name;

        try {
            if (method_exists($city, 'donationCenters') && $city->donationCenters()->count() > 0) {
                return redirect()->route('admin.data')
                    ->with('error', "Impossible de supprimer la ville '{$cityName}' car elle est utilisée par des centres de don.");
            }

            $city->delete();

            return redirect()->route('admin.data')
                ->with('success', "La ville '{$cityName}' a été supprimée avec succès.");
        } catch (\Exception $e) {
            return redirect()->route('admin.data')
                ->with('error', "Une erreur est survenue lors de la suppression de la ville '{$cityName}'. Elle est peut-être utilisée par d'autres enregistrements.");
        }
    }
}
