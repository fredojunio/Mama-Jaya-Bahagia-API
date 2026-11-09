<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Models\Coa;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Display a listing of the chart of accounts.
     */
    public function index(Request $request)
    {
        $query = Coa::query();

        if ($request->boolean('leaves_only')) {
            $query->where('is_parent', false);
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        $coas = $query->orderBy('code')->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $coas,
        ];

        return SuccessResource::make($return);
    }
}
