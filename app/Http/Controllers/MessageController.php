<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',

        ]);

        $message = Message::create($validatedData);
        return response()->json($message, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
        
        ]);

        $message = Message::find($id);
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        $message->update($validatedData);
        return response()->json($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        $message->delete();
        return response()->json(['message' => 'Message deleted successfully'], 200);
    }

    /**
     * Handle user authentication and return JWT token.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(compact('token'));
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
