<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Supports\CreateSupportDTO;
use App\DTO\Supports\UpdateSupportDTO;
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
        $supports = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 2),
            filter: $request->filter,
        );
        // $support = new Support();
        // $supports = $support->all(); // Gera uma collection (Array)

        // dd($supports->items());
        $filters = ['filter' => $request->get('filter', '')];

        return view('admin/supports/index', compact('supports', 'filters'));
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

        $this->service->new(
            CreateSupportDTO::makeFromRequest($request)
        );

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

        $support = $this->service->update(
            UpdateSupportDTO::makeFromRequest($request)
        );
        if(!$support) {
            return back();
        }

        /* Maneira semelhante de implementar a atualização
        $support->subject = $request->subject;
        $support->body = $request->body;
        $support->save();
        */

        return redirect()->route('supports.index');
    }

    public function destroy(string|int $id)
    {
        $this->service->delete($id);

        return redirect()->route('supports.index');
    }
}
