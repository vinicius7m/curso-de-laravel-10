<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Support $support /* Injeção de dependência do Laravel */ )
    {
        // $support = new Support();
        $supports = $support->all(); // Gera uma collection (Array)
        // dd($supports);

        return view('admin/supports/index', compact('supports'));
    }

    public function create()
    {
        return view('admin/supports/create');
    }

    public function store(Request $request, Support $support)
    {
        $data = $request->all();
        $data['status'] = 'a';

        $support = $support->create($data); // Objeto de suporte

        return redirect()->route('supports.index');
    }
}
