<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $batas = 5;

        $rents = Rent::orderBy('id', 'desc')
            ->paginate($batas);

        $no = ($rents->currentPage() - 1) * $batas + 1;

        $total_items     = Rent::count();
        $total_available = Rent::where('availability', 1)->count();
        $total_rented    = Rent::where('availability', 0)->count();
        $avg_price       = 'Rp ' . number_format(Rent::avg('price') ?? 0, 0, ',', '.');
        $highest_price   = 'Rp ' . number_format(Rent::max('price') ?? 0, 0, ',', '.');
        $lowest_price    = 'Rp ' . number_format(Rent::min('price') ?? 0, 0, ',', '.');

        return view('rents.index', compact(
            'rents',
            'no',
            'total_items',
            'total_available',
            'total_rented',
            'avg_price',
            'highest_price',
            'lowest_price'
        ));
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->search;

        $rents = Rent::where('name', 'like', "%" . $cari . "%")
            ->when($request->availability, function ($q, $availability) {
                $q->where('availability', $availability);
            })
            ->when($request->sort, function ($q, $sort) {
                $q->orderBy('price', $sort);
            }, function ($q) {
                $q->orderBy('id', 'desc');
            })
            ->paginate($batas);

        $jumlah_rents = $rents->count();
        $no = ($rents->currentPage() - 1) * $batas + 1;

        $total_items     = Rent::count();
        $total_available = Rent::where('availability', 1)->count();
        $total_rented    = Rent::where('availability', 0)->count();
        $avg_price       = 'Rp ' . number_format(Rent::avg('price') ?? 0, 0, ',', '.');
        $highest_price   = 'Rp ' . number_format(Rent::max('price') ?? 0, 0, ',', '.');
        $lowest_price    = 'Rp ' . number_format(Rent::min('price') ?? 0, 0, ',', '.');

        return view('rents.search', compact(
            'jumlah_rents',
            'rents',
            'no',
            'cari',
            'total_items',
            'total_available',
            'total_rented',
            'avg_price',
            'highest_price',
            'lowest_price'
        ));
    }

    public function create() {
        return view('rents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rent_type' => 'required|in:Harian,Mingguan',
            'availability' => 'required|boolean',
            'rent_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'name.required' => 'Nama rental wajib diisi.',
            'name.string' => 'Nama rental harus berupa teks.',
            'name.max' => 'Nama rental maksimal 255 karakter .',
            'price.required' => 'Harga sewa wajib diisi.',
            'price.numeric' => 'Harga sewa harus berupa angka.',
            'price.min' => 'Harga sewa tidak boleh kurang dari 0.',
            'rent_type.required' => 'Jenis sewa wajib dipilih.',
            'rent_type.in' => 'Jenis sewa harus berupa Harian atau Mingguan.',
            'availability.required' => 'Ketersediaan wajib dipilih.',
            'availability.boolean' => 'Ketersediaan tidak valid.',
            'rent_date.required' => 'Tanggal sewa wajib diisi.',
            'rent_date.date' => 'Tanggal sewa harus berupa tanggal yang valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, png, atau jpeg.',
            'image.max' => 'Ukuran gambar maksimal 2048 KB (2 MB).',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rents', 'public');
        }

        Rent::create([
            'name' => $request->name,
            'price' => $request->price,
            'rent_type' => $request->rent_type,
            'availability' => $request->availability,
            'rent_date' => $request->rent_date,
            'image' => $imagePath,
        ]);

        return redirect('/rents')->with('pesan', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rent = Rent::findOrFail($id);

        return view('rents.edit', compact('rent'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rent_type' => 'required|in:Harian,Mingguan',
            'availability' => 'required|boolean',
            'rent_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'name.required' => 'Nama rental wajib diisi.',
            'name.string' => 'Nama rental harus berupa teks.',
            'name.max' => 'Nama rental maksimal 255 karakter .',
            'price.required' => 'Harga sewa wajib diisi.',
            'price.numeric' => 'Harga sewa harus berupa angka.',
            'price.min' => 'Harga sewa tidak boleh kurang dari 0.',
            'rent_type.required' => 'Jenis sewa wajib dipilih.',
            'rent_type.in' => 'Jenis sewa harus berupa Harian atau Mingguan.',
            'availability.required' => 'Ketersediaan wajib dipilih.',
            'availability.boolean' => 'Ketersediaan tidak valid.',
            'rent_date.required' => 'Tanggal sewa wajib diisi.',
            'rent_date.date' => 'Tanggal sewa harus berupa tanggal yang valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, png, atau jpeg.',
            'image.max' => 'Ukuran gambar maksimal 2048 KB (2 MB).',
        ]);

        $rent = Rent::findOrFail($id);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'rent_type' => $request->rent_type,
            'availability' => $request->availability,
            'rent_date' => $request->rent_date,
        ];

        if ($request->hasFile('image')) {
            if ($rent->image) {
                Storage::disk('public')->delete($rent->image);
            }
            $data['image'] = $request->file('image')->store('rents', 'public');
        }

        $rent->update($data);

        return redirect('/rents')->with('pesan', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $rent = Rent::findOrFail($id);

        if ($rent->image) {
            Storage::disk('public')->delete($rent->image);
        }

        $rent->delete();

        return redirect('/rents')->with('pesan', 'Data berhasil dihapus!');
    }
}
