<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaConsultationController extends Controller
{
    public function index()
    {
        $consultations = Konsultasi::where('id_siswa', Auth::user()->id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        
        return view('konsultasi.index', compact('consultations'));
    }
}
