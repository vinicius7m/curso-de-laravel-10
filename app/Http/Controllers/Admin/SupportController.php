<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSupport;
use App\Models\Support;
use App\Services\SupportService;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    public function __construct(
        protected SupportService $service
    )
    {}

    public function index(Request $request /*Support $support  Injeção de dependência do Laravel */ )
    {
        $supports = $this->service->getAll($request->filter);
        // $support = new Support();
        // $supports = $support->all(); // Gera uma collection (Array)
        // dd($supports);

        return view('admin/supports/index', compact('supports'));
    }

    public function show(string|int $id)
    {
        // Support::find($id) - busca pela primary key;
        // Support::where('id', $id)->first() - busca pela coluna que selecionar e retorna o primeiro registro;
        // Support::where('id', '=', $id)->first() - adiciona critério de comparação
        if(!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports/show', compact('support'));
    }

    public function create()
    {
        return view('admin/supports/create');
    }

    public function store(StoreUpdateSupport $request, Support $support)
    {
        $data = $request->validated();
        $data['status'] = 'a';

        $support = $support->create($data); // Objeto de suporte

        return redirect()->route('supports.index');
    }

    public function edit(Support $support, string|int $id)
    {
        // if(!$support = $support->where('id', $id)->first()) {
        if(!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports.edit', compact('support'));
    }

    public function update(StoreUpdateSupport $request, Support $support, string $id)
    {
        if(!$support = $support->find($id)) {
            return back();
        }

        /* Maneira semelhante de implementar a atualização
        $support->subject = $request->subject;
        $support->body = $request->body;
        $support->save();
        */

        $support->update($request->validated());

        return redirect()->route('supports.index');
    }

    public function destroy(string|int $id)
    {
        $this->service->delete($id);

        return redirect()->route('supports.index');
    }
}
