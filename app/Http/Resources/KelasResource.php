<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_kelas' => $this->nama_kelas,
            'guru_id' => $this->guru_id,
            'guru' => new GuruResource($this->whenLoaded('guru')),
            'siswa' => SiswaResource::collection($this->whenLoaded('siswa')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
