<?php

namespace App\Http\Requests\Teacher;

use App\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //  On autorise uniquement les enseignan
        return auth()->check() && auth()->user()->isTeacher();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    $parentId = $this->input('parent_id');
                    $folder = $this->route('folder');
                    $folderId = $folder instanceof Folder ? $folder->id : $folder;

                    $exists = Folder::where('name', $value)
                        ->where('parent_id', $parentId)
                        ->where('id', '!=', $folderId) // exclut le dossier qu'on modifie
                        ->exists();

                    if ($exists) {
                        $fail("Un dossier nommé '{$value}' existe déjà dans ce dossier.");
                    }
                },
            ],
            'parent_id' => [
                'nullable',
                'exists:folders,id'
            ],
            'school_class_ids' => 'array',
            'school_class_ids.*' => 'exists:school_classes,id',
        ];
    }
}
