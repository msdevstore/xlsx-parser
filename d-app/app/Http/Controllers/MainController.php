<?php

namespace App\Http\Controllers;

use App\Exports\KnifeExport;
use App\Models\Knife;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    public function index()
    {
        $knives = Knife::get();
        return view('welcome', compact('knives'));
    }

    public function upload(Request $request)
    {
        $knives = json_decode($request->content);

        foreach ($knives as $knife) {
            $data = new Knife();
            foreach ($knife as $key => $value) {
                $data[$key] = $value;
            }
            $data->save();
        }
        return response(1);
    }

    public function getId($id) {
        return response()->json(Knife::where('id', $id)->first());
    }

    public function upsert(Request $request) {
        $status = Knife::updateOrCreate(
            ['id' => $request->id],
            [
                'Service IDs' => $request->serviceIds,
                'Pitch' => $request->pitch,
                'Type' => $request->type,
                'Gear' => $request->gear,
                'Shape' => $request->shape,
                'Blade Type' => $request->bladeType,
                'Cut Type' => $request->cutType,
                'Cut Position' => $request->cutPosition,
                'Corner Radius' => $request->cornerRadius,
                'Size Across' => $request->sizeAcross,
                'Size Around' => $request->sizeAround,
                'No Across' => $request->noAcross,
                'No Around' => $request->noAround,
                'Gap Across' => $request->gapAcross,
                'Gap Around' => $request->gapAround,
                'Center-to-Center Across' => $request->centerToCenterAcross,
                'Center-to-Center Around' => $request->centerToCenterAround,
                'Liner' => $request->liner,
                'Perforation' => $request->perforation,
                'Location' => $request->location,
                'Supplier ID' => $request->supplierId,
                'Notes' => $request->notes,
                'Size Width' => $request->sizeWidth,
                'Repeat Length' => $request->repeatLength,
                'No of Knife' => $request->noOfKnife,
                'Status' => $request->status
            ]
        );
        if ($status) return response(1);
        else return response(0);
    }

    public function delete($id) {
        $status = Knife::where('id', $id)->delete();
        if ($status) return response(1);
        else return response(0);
    }

    public function export() {
        return Excel::download(new KnifeExport, 'backup.xlsx');
    }
}
