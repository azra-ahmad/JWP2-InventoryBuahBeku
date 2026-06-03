<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'kategori_id' => ['required', 'exists:kategori_buah_beku,id'],
            'kode_produk' => [
                'required',
                'string',
                'max:20',
                Rule::unique('buah_beku', 'kode_produk')->ignore($product?->id),
            ],
            'nama_produk' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
