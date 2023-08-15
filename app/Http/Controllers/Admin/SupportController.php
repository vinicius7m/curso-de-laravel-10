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

    public function show(string|int $id)
    {
        // Support::find($id) - busca pela primary key;
        // Support::where('id', $id)->first() - busca pela coluna que selecionar e retorna o primeiro registro;
        // Support::where('id', '=', $id)->first() - adiciona critério de comparação
        if(!$support = Support::find($id)) {
            return back();
        }

        return view('admin/supports/show', compact('support'));
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

    public function edit(Support $support, string|int $id)
    {
        if(!$support = $support->where('id', $id)->first()) {
            return back();
        }

        return view('admin/supports.edit', compact('support'));
    }

    public function update(Request $request, Support $support, string $id)
    {
        if(!$support = $support->find($id)) {
            return back();
        }

        /* Maneira semelhante de implementar a atualização
        $support->subject = $request->subject;
        $support->body = $request->body;
        $support->save();
        */

        $support->update($request->only([
            'subject', 'body'
        ]));

        return redirect()->route('supports.index');
    }

    public function destroy(string|int $id)
    {
        if(!$support = Support::find($id)) {
            return back();
        }

        $support->delete();

        return redirect()->route('supports.index');
    }
}
