<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use App\Services\CurriculumSetupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    protected $curriculumSetupService;

    public function __construct(CurriculumSetupService $curriculumSetupService)
    {
        $this->curriculumSetupService = $curriculumSetupService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $availableCurriculums = $this->curriculumSetupService->getAvailableCurriculums();
        return view('auth.register', compact('availableCurriculums'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $availableCurriculumCodes = $this->curriculumSetupService->getAvailableCurriculums()
            ->pluck('code')
            ->toArray();

        $request->validate([
            // School Information
            'school_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'school_phone' => ['required', 'string', 'max:20'],
            'school_email' => ['required', 'string', 'email', 'max:255', 'unique:schools,email'],
            
            // Admin Information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            
            // Curriculum
            'curriculums' => ['required', 'array', 'min:1'],
            'curriculums.*' => ['required', 'string', Rule::in($availableCurriculumCodes)]
        ]);

        DB::transaction(function () use ($request) {
            // Create school
            $school = School::create([
                'name' => $request->school_name,
                'address' => $request->address,
                'phone' => $request->school_phone,
                'email' => $request->school_email,
                'status' => 'active',
                'subscription_status' => 'trial'
            ]);

            // Create admin user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'school_id' => $school->id,
                'role' => 'schooladmin'
            ]);

            event(new Registered($user));

            Auth::login($user);

            // Setup selected curriculums
            $this->curriculumSetupService->setupCurriculum($school, $request->curriculums);
        });

        return redirect(RouteServiceProvider::HOME);
    }
}
