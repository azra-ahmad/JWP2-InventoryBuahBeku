<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'buah_beku_id' => ['required', 'exists:buah_beku,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_keluar' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
