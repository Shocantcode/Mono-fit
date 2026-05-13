@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Nutrition</h1>
            <p style="font-size:13px;color:#666;margin-top:4px;">{{ now()->format('l, d F') }}</p>
        </div>
        <button onclick="document.getElementById('meal-modal').style.display='flex'" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:10px 16px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;">+ Log Meal</button>
    </div>

    {{-- Calorie Summary --}}
    <div style="background:linear-gradient(135deg,#0d1520,#0a1a2e);border:1px solid rgba(59,130,246,0.2);border-radius:20px;padding:22px;">
        <h3 style="font-size:14px;font-weight:600;color:#666;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.5px;">Daily Calories</h3>
        <div style="display:flex;align-items:center;gap:20px;">
            <div style="text-align:center;">
                <div style="font-size:40px;font-weight:800;color:#3b82f6;line-height:1;">{{ $calories ?? 0 }}</div>
                <div style="font-size:11px;color:#555;margin-top:4px;">Consumed</div>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                    <span style="font-size:12px;color:#666;">{{ $calories ?? 0 }} / 2000 kcal</span>
                    <span style="font-size:12px;color:#3b82f6;font-weight:600;">{{ min(100, round(($calories ?? 0) / 2000 * 100)) }}%</span>
                </div>
                <div style="height:8px;background:rgba(255,255,255,0.06);border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ min(100, round(($calories ?? 0) / 2000 * 100)) }}%;background:linear-gradient(90deg,#3b82f6,#6366f1);border-radius:4px;transition:width 0.5s;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:6px;">
                    <span style="font-size:11px;color:#444;">Remaining: <b style="color:#fff;">{{ max(0, 2000 - ($calories ?? 0)) }} kcal</b></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Macros --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:16px;">Macronutrients</h3>
        @php
            $macros = [
                ['name'=>'Protein','value'=>$protein ?? 0,'goal'=>150,'unit'=>'g','color'=>'#3b82f6','bg'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)'],
                ['name'=>'Carbs','value'=>$carbs ?? 0,'goal'=>250,'unit'=>'g','color'=>'#f59e0b','bg'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)'],
                ['name'=>'Fat','value'=>$fat ?? 0,'goal'=>65,'unit'=>'g','color'=>'#ef4444','bg'=>'rgba(239,68,68,0.1)','border'=>'rgba(239,68,68,0.2)'],
                ['name'=>'Water','value'=>$water ?? 0,'goal'=>3,'unit'=>'L','color'=>'#06b6d4','bg'=>'rgba(6,182,212,0.1)','border'=>'rgba(6,182,212,0.2)'],
            ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach($macros as $macro)
            @php $pct = min(100, round($macro['value'] / $macro['goal'] * 100)); @endphp
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="background:{{ $macro['bg'] }};border:1px solid {{ $macro['border'] }};border-radius:12px;padding:10px 12px;min-width:68px;text-align:center;">
                    <div style="font-size:17px;font-weight:800;color:{{ $macro['color'] }};">{{ $macro['value'] }}</div>
                    <div style="font-size:10px;color:#555;">{{ $macro['unit'] }}</div>
                </div>
                <div style="flex:1;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                        <span style="font-size:13px;font-weight:600;color:#ccc;">{{ $macro['name'] }}</span>
                        <span style="font-size:12px;color:{{ $macro['color'] }};font-weight:600;">{{ $pct }}% of goal</span>
                    </div>
                    <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:3px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $macro['color'] }};border-radius:3px;"></div>
                    </div>
                    <div style="font-size:11px;color:#444;margin-top:3px;">Goal: {{ $macro['goal'] }}{{ $macro['unit'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Today's Meals --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Today's Meals</h3>
        @php
            $meals = [
                ['time'=>'07:30','type'=>'Breakfast','name'=>'Oats + Banana + Protein Shake','kcal'=>480,'protein'=>35,'carbs'=>62,'fat'=>8,'emoji'=>'🌅'],
                ['time'=>'12:00','type'=>'Lunch','name'=>'Chicken Rice + Vegetables','kcal'=>620,'protein'=>42,'carbs'=>75,'fat'=>12,'emoji'=>'☀️'],
                ['time'=>'15:30','type'=>'Snack','name'=>'Greek Yogurt + Almonds','kcal'=>220,'protein'=>18,'carbs'=>15,'fat'=>10,'emoji'=>'🍎'],
                ['time'=>'19:00','type'=>'Dinner','name'=>'Salmon + Sweet Potato + Salad','kcal'=>580,'protein'=>38,'carbs'=>55,'fat'=>18,'emoji'=>'🌙'],
            ];
        @endphp
        @if(count($meals) > 0)
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($meals as $meal)
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:14px;">
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:38px;height:38px;background:rgba(255,255,255,0.05);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $meal['emoji'] }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <div style="font-size:11px;color:#666;margin-bottom:2px;">{{ $meal['time'] }} · {{ $meal['type'] }}</div>
                                <div style="font-size:14px;font-weight:600;color:#fff;">{{ $meal['name'] }}</div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;margin-left:8px;">
                                <div style="font-size:15px;font-weight:700;color:#ff4500;">{{ $meal['kcal'] }}</div>
                                <div style="font-size:10px;color:#555;">kcal</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:12px;margin-top:8px;">
                            <span style="font-size:11px;color:#3b82f6;">P: {{ $meal['protein'] }}g</span>
                            <span style="font-size:11px;color:#f59e0b;">C: {{ $meal['carbs'] }}g</span>
                            <span style="font-size:11px;color:#ef4444;">F: {{ $meal['fat'] }}g</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:24px 0;">
            <div style="font-size:40px;margin-bottom:10px;">🍽️</div>
            <p style="font-size:14px;color:#555;">No meals logged today yet.</p>
        </div>
        @endif
    </div>

    {{-- Water Tracker --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;">Water Intake 💧</h3>
            <span style="font-size:13px;font-weight:700;color:#06b6d4;">{{ $water ?? 0 }} / 3L</span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:8px;margin-bottom:16px;">
            @for($i = 1; $i <= 8; $i++)
            @php $filled = ($water ?? 0) * 2.67 >= $i; @endphp
            <div style="aspect-ratio:1;background:{{ $filled ? 'rgba(6,182,212,0.3)' : 'rgba(255,255,255,0.04)' }};border:1px solid {{ $filled ? 'rgba(6,182,212,0.5)' : 'rgba(255,255,255,0.08)' }};border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;">
                {{ $filled ? '💧' : '○' }}
            </div>
            @endfor
        </div>
        <button onclick="alert('Water logged! (Feature coming soon)')" style="width:100%;background:rgba(6,182,212,0.1);border:1px solid rgba(6,182,212,0.25);color:#06b6d4;padding:12px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;">+ Add 250ml Glass</button>
    </div>

    {{-- Nutrition Tips --}}
    <div style="background:linear-gradient(135deg,#0d1a0d,#0a1a0a);border:1px solid rgba(16,185,129,0.2);border-radius:20px;padding:18px;">
        <div style="display:flex;gap:12px;align-items:flex-start;">
            <div style="width:36px;height:36px;background:rgba(16,185,129,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">💡</div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#10b981;margin-bottom:4px;">Nutrition Tip</div>
                <div style="font-size:12px;color:#777;line-height:1.5;">Eat protein within 30 minutes post-workout to maximize muscle recovery and growth. Aim for 0.8-1g protein per kg of body weight daily.</div>
            </div>
        </div>
    </div>

</div>

{{-- Log Meal Modal --}}
<div id="meal-modal" style="display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.8);align-items:flex-end;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:#181818;border:1px solid rgba(255,255,255,0.1);border-radius:24px 24px 0 0;padding:28px 20px;width:100%;max-width:430px;max-height:90vh;overflow-y:auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:18px;font-weight:700;color:#fff;">Log a Meal</h3>
            <button onclick="document.getElementById('meal-modal').style.display='none'" style="background:rgba(255,255,255,0.08);border:none;color:#aaa;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
        </div>
        <form action="#" method="POST" style="display:flex;flex-direction:column;gap:14px;">
            @csrf
            <div>
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Meal Type</label>
                <select name="type" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    <option value="breakfast" style="background:#1a1a1a;">Breakfast</option>
                    <option value="lunch" style="background:#1a1a1a;">Lunch</option>
                    <option value="dinner" style="background:#1a1a1a;">Dinner</option>
                    <option value="snack" style="background:#1a1a1a;">Snack</option>
                </select>
            </div>
            <div>
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Food Name</label>
                <input type="text" name="name" placeholder="e.g. Chicken Rice" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
            </div>
            <div>
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Calories (kcal)</label>
                <input type="number" name="calories" placeholder="500" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                <div>
                    <label style="font-size:12px;color:#3b82f6;display:block;margin-bottom:6px;">Protein (g)</label>
                    <input type="number" name="protein" placeholder="30" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(59,130,246,0.2);border-radius:10px;padding:12px 10px;color:#fff;font-size:14px;text-align:center;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;color:#f59e0b;display:block;margin-bottom:6px;">Carbs (g)</label>
                    <input type="number" name="carbs" placeholder="50" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(245,158,11,0.2);border-radius:10px;padding:12px 10px;color:#fff;font-size:14px;text-align:center;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;color:#ef4444;display:block;margin-bottom:6px;">Fat (g)</label>
                    <input type="number" name="fat" placeholder="15" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:12px 10px;color:#fff;font-size:14px;text-align:center;outline:none;">
                </div>
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;margin-top:4px;">
                Save Meal
            </button>
        </form>
    </div>
</div>

@endsection
