<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForeignerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TestStatusController;

// Authentication routes with rate limiting
Route::middleware(['rate.limit:5,1'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Health check routes (public access) with rate limiting
Route::middleware(['rate.limit:10,1'])->group(function () {
    Route::get('/health', [App\Http\Controllers\HealthController::class, 'index']);
    Route::get('/health/simple', [App\Http\Controllers\HealthController::class, 'simple']);
});

// Public test route (no authentication required)
Route::get('/test-form-public', function() {
    return view('foreigners.debug');
})->name('test.form.public');

// Protected routes (require authentication)
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/map', [DashboardController::class, 'map'])->name('dashboard.map');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    
    // Debug route for map data
    Route::get('/debug/map-data', function() {
        $allForeigners = \App\Models\Foreigner::select(['id', 'first_name', 'last_name', 'nationality', 'residence_permit_type', 'status',
                'city', 'state_province', 'passport_number', 'entry_date', 'residence_permit_expiry_date',
                'latitude', 'longitude'])
            ->get();
            
        $foreignersWithCoords = \App\Models\Foreigner::withCoordinates()
            ->select(['id', 'first_name', 'last_name', 'nationality', 'residence_permit_type', 'status',
                'city', 'state_province', 'passport_number', 'entry_date', 'residence_permit_expiry_date',
                'latitude', 'longitude'])
            ->get();
        
        $regions = \App\Models\Region::select(['id', 'name', 'code', 'country', 'latitude', 'longitude'])->get();
        
        return response()->json([
            'total_foreigners' => $allForeigners->count(),
            'foreigners_with_coordinates' => $foreignersWithCoords->count(),
            'foreigners' => $foreignersWithCoords->toArray(),
            'all_foreigners_sample' => $allForeigners->take(3)->map(function($f) {
                return [
                    'name' => $f->first_name . ' ' . $f->last_name,
                    'has_lat' => !is_null($f->latitude),
                    'has_lng' => !is_null($f->longitude),
                    'lat' => $f->latitude,
                    'lng' => $f->longitude
                ];
            }),
            'regions_count' => $regions->count(),
            'regions' => $regions->toArray()
        ]);
    });
    Route::resource('foreigners', ForeignerController::class);
    
    // Test route for form debugging
    Route::get('/foreigners/test-form', function() {
        return view('foreigners.test');
    })->name('foreigners.test');
    
    // Debug route for form debugging
    Route::get('/foreigners/debug-form', function() {
        return view('foreigners.debug');
    })->name('foreigners.debug');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.delete-avatar');
    
    // Export routes
    Route::get('/exports', [ExportController::class, 'index'])->name('exports.index');
    Route::post('/exports/foreigners', [ExportController::class, 'exportForeigners'])->name('export.foreigners');
    Route::get('/exports/statistics', [ExportController::class, 'exportStatistics'])->name('export.statistics');
    
    // Import routes
    Route::get('/imports', [ImportController::class, 'index'])->name('imports.index');
    Route::post('/imports/foreigners', [ImportController::class, 'importForeigners'])->name('import.foreigners');
    Route::get('/imports/template', [ImportController::class, 'downloadTemplate'])->name('import.template');
    
    // Test routes (for development/testing)
    Route::get('/test/status-update', [TestStatusController::class, 'testStatusUpdate'])->name('test.status-update');
});
