<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('notificaciones.index');
    }

    public function apiIndex(Request $request)
    {
        $query = Notificacion::with('incidencia')
            ->where('usuario_id', Auth::id());

        // Filtro: Leído / No leído
        if ($request->has('estado') && $request->estado !== 'todos') {
            if ($request->estado === 'no_leido') {
                $query->where('leida', false);
            } elseif ($request->estado === 'leido') {
                $query->where('leida', true);
            }
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'LIKE', "%{$buscar}%")
                  ->orWhere('mensaje', 'LIKE', "%{$buscar}%");
            });
        }

        $orden = $request->get('orden', 'desc'); 
        $query->orderBy('created_at', $orden);

        return response()->json($query->get());
    }

    public function marcarYVer (Notificacion $notificacion)
    {
        if ($notificacion->usuario_id !==Auth::id()){
            abort(403);
        }
        $notificacion->update(['leida' => true]);
        return redirect()->route('incidencias.show', $notificacion->incidencia_id);
    }

    public function unreadCount()
    {
        $unreadCount = Notificacion::where('usuario_id', auth()->id())
            ->where('leida', false)
            ->count();

        return response()->json([
            'unread_count' => $unreadCount
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notificacion $notificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
