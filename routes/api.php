Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sections/{section}/class-levels', function (Section $section) {
        return $section->classLevels()->where('is_active', true)->get();
    });
}); 