<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VarietasAnggur;
use App\Models\PenyakitAnggur;
use App\Models\SebaranVarietas;
use App\Models\SebaranPenyakit;
use App\Models\CategoryClass;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total admin
        $totalAdmin = User::where('roles', 'ADMIN')->count();

        // Hitung total users
        $totalUsers = User::where('roles', 'USER')->count();

        // Hitung total Varietas
        $totalVarietas = VarietasAnggur::count();

        // Hitung total Penyakit Dan Hama
        $totalHama = PenyakitAnggur::count();

        // Hitung Sebaran Varietas
        $totalSebaranVarietas = SebaranVarietas::count();

        // Hitung Sebaran Penyakit Dan Hama
        $totalSebaranHama = SebaranPenyakit::count();

        // Hitung Modul Budidaya
        $totalModul = CategoryClass::count();

        return view('pages.dashboard', compact('totalAdmin', 'totalUsers', 'totalVarietas', 'totalHama', 'totalSebaranVarietas', 'totalSebaranHama', 'totalModul'));
    }
}
