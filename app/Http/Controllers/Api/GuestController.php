<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class GuestController extends Controller
{
    //
    public function show(string $guestCode): JsonResponse
    {
        $guest = Guest::where('guest_code', $guestCode)->first();

        if (!$guest) {
            return response()->json([
                'message' => 'Guest not found.',
            ], 404);
        }

        return response()->json([
            'guest_name' => $guest->guest_name,
            'max_guests' => $guest->max_guests,
            'confirmed_guests' => $guest->confirmed_guests ?? 0,
            'confirmed' => !is_null($guest->confirmed_at),
        ]);
    }

    public function rsvp(Request $request, string $guestCode): JsonResponse
    {
        $guest = Guest::where('guest_code', $guestCode)->first();

        if (!$guest) {
            return response()->json([
                'message' => 'Guest not found.',
            ], 404);
        }

        $validated = $request->validate([
            'confirmed_guests' => [
                'required',
                'integer',
                'min:1',
                'max:' . $guest->max_guests,
            ],
        ]);

        if ($guest->confirmed_at) {
            return response()->json([
                'message' => 'La confirmación ya fue registrada.',
            ], 409);
        }

        $guest->update([
            'confirmed_guests' => $validated['confirmed_guests'],
            'confirmed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Se registró su asistencia.',
            'guest_name' => $guest->guest_name,
            'max_guests' => $guest->max_guests,
            'confirmed_guests' => $guest->confirmed_guests,
            'confirmed_at' => $guest->confirmed_at,
        ]);
    }

}
