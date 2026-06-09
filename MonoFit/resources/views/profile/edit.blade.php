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

    {{-- Edit Profile Section --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Profile Information</h2>

        <form method="POST" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:12px;">
            @csrf
            @method('patch')

            <div>
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="Your name" />
                @if($errors->has('name'))
                    <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div>
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Email Address</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;color:#fff;font-size:14px;" placeholder="your@email.com" />
                @if($errors->has('email'))
                    <p style="color:#ff4500;font-size:12px;margin-top:4px;">{{ $errors->first('email') }}</p>
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
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p style="color:#10b981;font-size:13px;margin-top:8px;">Profile updated successfully!</p>
            @endif
        </form>
    </div>

    {{-- Recent Workout History and Personal Records --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Workout History & Personal Records</h2>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;padding:18px;">
                <h3 style="font-size:14px;font-weight:700;color:#fff;margin-bottom:12px;">Personal Records</h3>
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

            <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;padding:18px;">
                <h3 style="font-size:14px;font-weight:700;color:#fff;margin-bottom:12px;">Recent Workouts</h3>
                @if($recentWorkouts->isEmpty())
                    <p style="color:#888;font-size:13px;">No workouts logged yet.</p>
                @else
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        @foreach($recentWorkouts as $workout)
                            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:12px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                    <span style="color:#fff;font-weight:700;">{{ $workout->date->format('d M Y') }}</span>
                                    <span style="color:#888;font-size:12px;">{{ $workout->total_sets ?? 0 }} sets</span>
                                </div>
                                <div style="color:#bbb;font-size:13px;margin-bottom:8px;">Total weight: {{ $workout->total_weight ? number_format($workout->total_weight, 1) . ' kg' : '—' }}</div>
                                <div style="display:grid;gap:6px;">
                                    @foreach($workout->exercises as $exercise)
                                        <div style="display:flex;justify-content:space-between;color:#ddd;font-size:13px;">
                                            <span>{{ $exercise['name'] ?? 'Exercise' }}</span>
                                            <span>{{ $exercise['sets'] }}x{{ $exercise['reps'] }} {{ isset($exercise['weight']) && is_numeric($exercise['weight']) ? $exercise['weight'] . ' kg' : $exercise['weight'] ?? 'Bodyweight' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Change Password Section --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h2 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Change Password</h2>

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

    {{-- Delete Account Section --}}
    <div style="background:#141414;border:1px solid rgba(239,68,68,0.2);border-radius:20px;padding:20px;">
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

            <button type="submit" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:8px;">
                Delete My Account
            </button>
        </form>
    </div>

</div>
@endsection
