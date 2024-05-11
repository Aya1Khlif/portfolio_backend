<?php

namespace App\Http\Controllers;

use App\Models\project;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function create()
    {
        return response()->json(['message' => 'Provide data to create a new project'], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|integer',
        ]);

        $project = Project::create($validatedData);
        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        return response()->json($project);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        return response()->json($project, 200);
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|integer',
        ]);

        $project->update($validatedData);
        return response()->json($project, 200);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        $project->delete();
        return response()->json(null, 204);
    }
    //  // استرجاع جميع المشاريع لعرضها في قسم "My Projects"
    //  public function getMyProjects()
    //  {
    //      $projects = Project::all();
    //      return response()->json($projects);
    //  }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(compact('token'));
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
