<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SiswaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_siswa' => $this->nama_siswa,
            'Bb' => $this->Bb,
            'Tb' => $this->Tb,
            'kelas_id' => $this->kelas_id,
            'kelas' => new KelasResource($this->whenLoaded('kelas')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
