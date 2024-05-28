<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/tailadmin/{path}', function (string $path) {
    $path = trim(substr($path, 0, str_ends_with($path, '-view') ? -5 : null), '/\\');
    $path = trim(substr($path, 0, str_ends_with($path, 'View') ? -4 : null), '/\\');

    $file = str($path)?->replace('//', '/')?->ltrim('/\\')?->rtrim('/\\')?->afterLast('/')?->append('View')?->studly();

    $newPath = str(substr_count($path, '/') ? $path : '')
        ?->ltrim('/\\')
        ?->rtrim('/\\')
        ?->beforeLast('/')
        ?->append('/' . $file)
        ?->prepend('tailadmin/')
        ?->replace('//', '/')
        ?->toString();

    return Inertia::render($newPath, [
        'path' => $path,
        'newPath' => $newPath,
    ]);
})?->where('path', '.*')
?->name('tailadmin_view');

Route::get('/tables', function () {
    return Inertia::render('tailadmin/TablesView', [
        //
    ]);
})?->name('tables');

Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('dev-partials')->group(function () {
    Route::view('inline-component', 'dev-partials.inline-component', [
        'view' => 'proposal-templates.fake.demo',
        'data' => Database\Factories\ProposalFactory::fakeContentData(),
    ]);
});
