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

            <button type="submit" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:8px;">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p style="color:#10b981;font-size:13px;margin-top:8px;">Profile updated successfully!</p>
            @endif
        </form>
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
