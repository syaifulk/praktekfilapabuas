<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User; // <-- tambahkan ini
use Illuminate\Support\Facades\Hash; // (opsional, jika butuh hashing password)

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->record = new User($data); // gunakan class yang sudah di-import
        $this->record->save();

        if (isset($data['role'])) {
            $this->record->syncRoles($data['role']);
        }

        return $data;
    }
}
