@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header with Logout --}}
    <div style="background: linear-gradient(135deg, #1a0800, #250d00); border: 1px solid rgba(255,69,0,0.25); border-radius: 20px; padding: 22px; position: relative; overflow: hidden;">
        <div style="position:absolute;top:-40px;right:-40px;width:130px;height:130px;background:radial-gradient(circle,rgba(255,69,0,0.2) 0%,transparent 70%);pointer-events:none;"></div>
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;">
            <div>
                <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;margin-bottom:4px;">{{ Auth::user()->name }}</h1>
                <p style="font-size:13px;color:#888;">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:flex;">
                @csrf
                <button type="submit" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:10px 20px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:opacity 0.2s;white-space:nowrap;">
                    Logout
                </button>
            </form>
        </div>
    </div>

    @php
        $showProfileSubpage = $errors->has('name') || $errors->has('age') || $errors->has('gender') || $errors->has('height') || $errors->has('weight') || $errors->has('activity_level') || $errors->has('fitness_goal') || $errors->has('email');
        $showSecuritySubpage = $errors->has('password') || ($errors->has('current_password') && ! $showProfileSubpage);
    @endphp

    <div style="display:block;margin-top:16px;">
        <button type="button" id="openProfilePage" style="display:block;width:100%;text-align:center;background:linear-gradient(135deg,#1f2937,#111827);color:#fff;border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:14px 18px;font-size:14px;font-weight:700;cursor:pointer;margin-bottom:12px;">Edit Profile</button>
        <button type="button" id="openSecurityPage" style="display:block;width:100%;text-align:center;background:linear-gradient(135deg,#111827,#0f172a);color:#fff;border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:14px 18px;font-size:14px;font-weight:700;cursor:pointer;">Security Settings</button>
    </div>

    {{-- Profile Information Section --}}
    <div id="profileInfoPage" style="display:{{ $showProfileSubpage ? 'block' : 'none' }};background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-top:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#fff;margin-bottom:8px;">Profile Information</h2>
                <p style="font-size:13px;color:#888;">Update your name and body metrics. Email changes are managed in Security Settings.</p>
            </div>
            <button type="button" id="closeProfilePage" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.12);color:#fff;padding:10px 16px;border-radius:14px;font-size:13px;font-weight:600;cursor:pointer;">Close</button>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:14px;">
            @csrf
            @method('patch')
            <input type="hidden" name="email" value="{{ Auth::user()->email }}" />

            <div style="display:grid;gap:10px;">
                <label style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:0.5px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;color:#fff;font-size:14px;" placeholder="Your name" />
                @if($errors->has('name'))
                    <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Age</label>
                    <input type="number" name="age" value="{{ old('age', $onboarding?->age) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="Age" />
                    @if($errors->has('age'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('age') }}</p>
                    @endif
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Gender</label>
                    <select name="gender" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        <option value="male" {{ old('gender', $onboarding?->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $onboarding?->gender) === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @if($errors->has('gender'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('gender') }}</p>
                    @endif
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Height (cm)</label>
                    <input type="number" name="height" value="{{ old('height', $onboarding?->height) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="170" />
                    @if($errors->has('height'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('height') }}</p>
                    @endif
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $onboarding?->weight) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="70" />
                    @if($errors->has('weight'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('weight') }}</p>
                    @endif
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Activity Level</label>
                    <select name="activity_level" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        <option value="sedentary" {{ old('activity_level', $onboarding?->activity_level) === 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                        <option value="light" {{ old('activity_level', $onboarding?->activity_level) === 'light' ? 'selected' : '' }}>Light</option>
                        <option value="moderate" {{ old('activity_level', $onboarding?->activity_level) === 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="active" {{ old('activity_level', $onboarding?->activity_level) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="very_active" {{ old('activity_level', $onboarding?->activity_level) === 'very_active' ? 'selected' : '' }}>Very Active</option>
                    </select>
                    @if($errors->has('activity_level'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('activity_level') }}</p>
                    @endif
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Fitness Goal</label>
                    <select name="fitness_goal" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        <option value="fat_loss" {{ old('fitness_goal', $onboarding?->fitness_goal) === 'fat_loss' ? 'selected' : '' }}>Fat Loss</option>
                        <option value="muscle_gain" {{ old('fitness_goal', $onboarding?->fitness_goal) === 'muscle_gain' ? 'selected' : '' }}>Muscle Gain</option>
                        <option value="maintenance" {{ old('fitness_goal', $onboarding?->fitness_goal) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @if($errors->has('fitness_goal'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('fitness_goal') }}</p>
                    @endif
                </div>
            </div>

            <button type="submit" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:8px;">
                Save Profile Information
            </button>

            @if (session('status') === 'profile-updated')
                <p style="color:#10b981;font-size:13px;margin-top:8px;">Profile updated successfully!</p>
            @endif
        </form>
    </div>

    {{-- Security Settings --}}
    <div id="securityPage" style="display:{{ $showSecuritySubpage ? 'block' : 'none' }};background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-top:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#fff;margin-bottom:8px;">Security Settings</h2>
                <p style="font-size:13px;color:#888;">Change your password or update your email securely with current password confirmation.</p>
            </div>
            <button type="button" id="closeSecurityPage" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.12);color:#fff;padding:10px 16px;border-radius:14px;font-size:13px;font-weight:600;cursor:pointer;">Close</button>
        </div>

        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;padding:18px;">
            <h3 style="font-size:14px;font-weight:700;color:#fff;margin-bottom:12px;">Change Password</h3>
            <form method="POST" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:12px;">
                @csrf
                @method('put')

                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Current Password</label>
                    <input type="password" name="current_password" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="••••••••" />
                    @if($errors->has('current_password'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('current_password') }}</p>
                    @endif
                </div>

                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">New Password</label>
                    <input type="password" name="password" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="••••••••" />
                    @if($errors->has('password'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Confirm Password</label>
                    <input type="password" name="password_confirmation" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="••••••••" />
                </div>

                <button type="submit" style="background:linear-gradient(135deg,#3b82f6,#1e40af);color:#fff;border:none;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:8px;">
                    Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <p style="color:#10b981;font-size:13px;margin-top:8px;">Password updated successfully!</p>
                @endif
            </form>
        </div>

        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;padding:18px;">
            <h3 style="font-size:14px;font-weight:700;color:#fff;margin-bottom:12px;">Update Email</h3>
            <form method="POST" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:12px;">
                @csrf
                @method('patch')

                <input type="hidden" name="name" value="{{ old('name', Auth::user()->name) }}" />
                <input type="hidden" name="age" value="{{ old('age', $onboarding?->age) }}" />
                <input type="hidden" name="gender" value="{{ old('gender', $onboarding?->gender) }}" />
                <input type="hidden" name="height" value="{{ old('height', $onboarding?->height) }}" />
                <input type="hidden" name="weight" value="{{ old('weight', $onboarding?->weight) }}" />
                <input type="hidden" name="activity_level" value="{{ old('activity_level', $onboarding?->activity_level) }}" />
                <input type="hidden" name="fitness_goal" value="{{ old('fitness_goal', $onboarding?->fitness_goal) }}" />

                <div style="display:grid;gap:10px;">
                    <label style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:0.5px;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;color:#fff;font-size:14px;" placeholder="your@email.com" />
                    @if($errors->has('email'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div style="display:grid;gap:10px;">
                    <label style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:0.5px;">Current Password</label>
                    <input type="password" name="current_password" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;color:#fff;font-size:14px;" placeholder="Enter current password" />
                    @if($errors->has('current_password'))
                        <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('current_password') }}</p>
                    @endif
                </div>

                <button type="submit" style="background:linear-gradient(135deg,#10b981,#047857);color:#fff;border:none;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:8px;">
                    Update Email
                </button>
            </form>
        </div>
    </div>

    {{-- Records and Workouts --}}
    <div style="display:flex;flex-direction:column;gap:16px;margin-top:16px;">
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;" id="personal-records">
            <h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Personal Records</h2>
            <div style="display:grid;gap:12px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#bbb;">Workouts completed</span>
                    <strong style="color:#fff;">{{ $personalRecords['workouts_completed'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#bbb;">Best workout weight</span>
                    <strong style="color:#fff;">{{ $personalRecords['best_workout_weight'] ? number_format($personalRecords['best_workout_weight'], 1) . ' kg' : '—' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#bbb;">Best workout sets</span>
                    <strong style="color:#fff;">{{ $personalRecords['best_workout_sets'] ?? '—' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#bbb;">Heaviest lift</span>
                    <strong style="color:#fff;">{{ $personalRecords['heaviest_lift']['name'] ? $personalRecords['heaviest_lift']['name'] . ' (' . number_format($personalRecords['heaviest_lift']['weight'], 1) . ' kg)' : '—' }}</strong>
                </div>
            </div>
        </div>

        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
            <h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Recent Workouts</h2>
            @if($recentWorkouts->isEmpty())
                <p style="color:#888;font-size:13px;">No workouts logged yet.</p>
            @else
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($recentWorkouts as $workout)
                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:14px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <span style="color:#fff;font-weight:700;">{{ $workout->date->format('d M Y') }}</span>
                                <span style="color:#888;font-size:12px;">{{ $workout->total_sets ?? 0 }} sets</span>
                            </div>
                            <div style="color:#bbb;font-size:13px;margin-bottom:10px;">Total weight: {{ $workout->total_weight ? number_format($workout->total_weight, 1) . ' kg' : '—' }}</div>
                            <div style="display:grid;gap:6px;">
                                @foreach($workout->exercises as $exercise)
                                    <div style="display:flex;justify-content:space-between;color:#ddd;font-size:13px;">
                                        <span>{{ $exercise['name'] ?? 'Exercise' }}</span>
                                        <span>
                                            @php
                                                $exerciseSets = $exercise['sets'] ?? [];
                                                $setCount = is_array($exerciseSets) ? count($exerciseSets) : 1;
                                                $repsText = is_array($exerciseSets) ? collect($exerciseSets)->pluck('reps')->join(', ') : ($exercise['reps'] ?? '');
                                                $weightLabel = isset($exercise['weight']) && is_numeric($exercise['weight']) ? $exercise['weight'] . ' kg' : ($exercise['weight'] ?? 'Bodyweight');
                                            @endphp
                                            {{ $setCount }}x{{ $repsText }} {{ $weightLabel }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div style="background:#111827;border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:20px;margin-top:16px;">
        <h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:12px;">Need help?</h2>
        <p style="font-size:13px;color:#ccc;margin-bottom:16px;">Report a bug or contact support if you find any issue in the app.</p>
        <form onsubmit="event.preventDefault(); alert('Demo only: this form does not save data.');" style="display:flex;flex-direction:column;gap:14px;">
            <input type="text" name="bug_subject" placeholder="Subject" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;color:#fff;font-size:14px;" />
            <input type="email" name="bug_email" placeholder="Your email (optional)" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;color:#fff;font-size:14px;" />
            <textarea name="bug_message" rows="5" placeholder="Describe the issue..." style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;color:#fff;font-size:14px;resize:vertical;"></textarea>
            <button type="submit" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border:none;border-radius:16px;padding:14px 18px;font-size:14px;font-weight:700;cursor:pointer;">Send Feedback</button>
            <p style="font-size:12px;color:#888;">Demo only — this form does not save data.</p>
        </form>
    </div>

    <div id="delete-account" style="background:#141414;border:1px solid rgba(239,68,68,0.2);border-radius:20px;padding:20px;margin-top:16px;">
        <h2 style="font-size:16px;font-weight:700;color:#ef4444;margin-bottom:14px;">Delete Account</h2>
        <p style="font-size:13px;color:#888;margin-bottom:14px;">Once you delete your account, there is no going back. Please be certain.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This cannot be undone.');" style="display:flex;flex-direction:column;gap:12px;">
            @csrf
            @method('delete')
            <div>
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Confirm with Password</label>
                <input type="password" name="password" required style="width:100%;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="Enter your password" />
                @if($errors->has('password'))
                    <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:8px;">Delete My Account</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var openProfileBtn = document.getElementById('openProfilePage');
        var openSecurityBtn = document.getElementById('openSecurityPage');
        var closeProfileBtn = document.getElementById('closeProfilePage');
        var closeSecurityBtn = document.getElementById('closeSecurityPage');
        var profilePage = document.getElementById('profileInfoPage');
        var securityPage = document.getElementById('securityPage');

        if (openProfileBtn) {
            openProfileBtn.addEventListener('click', function () {
                profilePage.style.display = 'block';
                securityPage.style.display = 'none';
            });
        }

        if (openSecurityBtn) {
            openSecurityBtn.addEventListener('click', function () {
                securityPage.style.display = 'block';
                profilePage.style.display = 'none';
            });
        }

        if (closeProfileBtn) {
            closeProfileBtn.addEventListener('click', function () {
                profilePage.style.display = 'none';
            });
        }

        if (closeSecurityBtn) {
            closeSecurityBtn.addEventListener('click', function () {
                securityPage.style.display = 'none';
            });
        }
    });
</script>
@endsection
