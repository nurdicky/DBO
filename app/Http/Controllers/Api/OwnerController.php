<?php

namespace App\Http\Controllers\Api;

use App\Owner;
use App\Transformers\OwnerTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class OwnerController extends Controller
{
    public function update(Request $request, $id)
    {
        $host = request()->getHttpHost();
        $owners = Owner::find($id);
        
        

        if (!@$owners) {
            return response()->json(['error' => true, 'message' => 'Sorry, your ID not found !'], 401);
        }

        if ($request->hasFile('file')) {
            $input = $request->file('file');
            $input = $request->all();
            $input['file'] = 'http://'.$host.'/public/images/'.$request->file->getClientOriginalName();
            $request->file->move(public_path('images'), $input['file']);
        }
        else{
            $input = $request->all();
            $input['file'] = $owners->file;
        }

        $owners->owner_name = (@$input['nama'] == null) ? $owners->owner_name : $input['nama'];
        $owners->owner_address = (@$input['alamat'] == null) ? $owners->owner_address : $input['alamat'];
        $owners->owner_identity_number = (@$input['nomor_ktp'] == null) ? $owners->owner_identity_number : $input['nomor_ktp'];
        $owners->owner_avatar = (@$input['file'] == null) ? $owners->owner_avatar : $input['file'];
        $owners->save();

        return response()->json([
            'message' => 'Update owner successfully !',
            'data' => $owners
        ], 201);
    }
}
