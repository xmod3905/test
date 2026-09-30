<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ItemCategory;
use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'kode'     => 'nullable||string',
            'nama'     => 'nullable||string',
            'hargamin' => 'nullable||numeric||min:0',
            'hargamax' => 'nullable||numeric||min:0||gte:hargamin',
        ]);

        $data_search = MasterItem::query();

        if (! empty($validated['kode'])) {
            $data_search->where('kode', $validated['kode']);
        }

        if (! empty($validated['nama'])) {
            $data_search->where('name', 'LIKE', '%' . validated['nama'] . '%');
        }

        if (! empty($validated['hargamin'])) {
            $data_search->where('harga_beli', '>=', $validated['hargamin']);
        }

        if (! empty($validated['hargamax'])) {
            $data_search->where('harga_beli', '<=', $validated['hargamax']);
        }

        $data_search = $data_search
            ->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')
            ->orderBy('id')
            ->get();

        return json_encode([
            'status' => 200,
            'data'   => $data_search,
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::with('categories')->findOrFail($id);
        }

        $categories = ItemCategory::orderBy('nama')->get();

        $data['item']       = $item;
        $data['method']     = $method;
        $data['categories'] = $categories;

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'harga_beli'   => 'required|integer|min:0',
            'laba'         => 'required|integer|min:0',
            'supplier'     => 'required|string|max:255',
            'jenis'        => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'categories'   => 'nullable|array',
            'categories.*' => 'exists:item_categories,id',
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;

            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            sleep(3);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode      = $data_item->kode;
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('items', 'public');
        }

        $categories = $validated['categories'] ?? [];
        unset($validated['categories']);

        $data_item->fill($validated);
        $data_item->kode = $kode;
        $data_item->save();

        $data_item->categories()->sync($categories);

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba       = rand(10, 99);
            $item->kode       = $kode;
            $item->supplier   = $this->getRandomSupplier();
            $item->jenis      = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array  = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array  = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
