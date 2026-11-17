<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Http\Resources\UserResource;
use App\Http\Requests\AddToCollectionRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function collection(User $user)
    {
        $user->load('media');
        return new UserResource($user);
    }

    public function addToCollection(AddToCollectionRequest $request, User $user)
    {
        $mediaId = $request->validated()['media_id'];

        if ($user->media()->where('media.id', $mediaId)->exists()) {
            return response()->json(['message' => 'Media sudah ada di koleksi'], 409);
        }

        $user->media()->attach($mediaId);

        return response()->json(['message' => 'Media berhasil ditambahkan ke koleksi'], 201);
    }

    public function removeFromCollection(User $user, Media $media)
    {
        if (! $user->media()->where('media.id', $media->id)->exists()) {
            return response()->json(['message' => 'Media tidak ada di koleksi'], 404);
        }

        $user->media()->detach($media->id);

        return response()->json(['message' => 'Media berhasil dihapus dari koleksi'], 200);
    }
}
