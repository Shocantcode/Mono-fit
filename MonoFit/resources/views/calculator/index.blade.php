@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Body Calculator</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">Calculate your BMI, BMR & TDEE</p>
    </div>

    {{-- Input Form --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:16px;">Your Stats</h3>

        {{-- Gender Toggle --}}
        <div style="margin-bottom:16px;">
            <label style="font-size:11px;font-weight:700;color:#777;display:block;margin-bottom:8px;letter-spacing:0.5px;text-transform:uppercase;">Gender</label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <button onclick="setGender('male')" id="gender-male" style="padding:12px;border-radius:12px;border:1px solid rgba(255,69,0,0.4);background:rgba(255,69,0,0.12);color:#ff4500;font-size:14px;font-weight:600;cursor:pointer;font-family:'Figtree',sans-serif;">♂ Male</button>
                <button onclick="setGender('female')" id="gender-female" style="padding:12px;border-radius:12px;border:1px solid rgba(255,255,255,0.09);background:rgba(255,255,255,0.04);color:#777;font-size:14px;font-weight:600;cursor:pointer;font-family:'Figtree',sans-serif;">♀ Female</button>
            </div>
        </div>

        {{-- Age & Height Row --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
            <div>
                <label style="font-size:11px;font-weight:700;color:#777;display:block;margin-bottom:8px;letter-spacing:0.5px;text-transform:uppercase;">Age (years)</label>
                <input type="number" id="input-age" value="25" min="10" max="100" oninput="calculate()" style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:12px;padding:13px 14px;color:#fff;font-size:16px;font-family:'Figtree',sans-serif;outline:none;text-align:center;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:700;color:#777;display:block;margin-bottom:8px;letter-spacing:0.5px;text-transform:uppercase;">Height (cm)</label>
                <input type="number" id="input-height" value="175" min="100" max="250" oninput="calculate()" style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:12px;padding:13px 14px;color:#fff;font-size:16px;font-family:'Figtree',sans-serif;outline:none;text-align:center;">
            </div>
        </div>

        {{-- Weight --}}
        <div style="margin-bottom:16px;">
            <label style="font-size:11px;font-weight:700;color:#777;display:block;margin-bottom:8px;letter-spacing:0.5px;text-transform:uppercase;">Weight (kg)</label>
            <input type="number" id="input-weight" value="70" min="30" max="300" step="0.5" oninput="calculate()" style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:12px;padding:13px 14px;color:#fff;font-size:16px;font-family:'Figtree',sans-serif;outline:none;text-align:center;">
        </div>

        {{-- Activity Level --}}
        <div>
            <label style="font-size:11px;font-weight:700;color:#777;display:block;margin-bottom:8px;letter-spacing:0.5px;text-transform:uppercase;">Activity Level</label>
            <select id="input-activity" onchange="calculate()" style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:12px;padding:13px 14px;color:#fff;font-size:14px;font-family:'Figtree',sans-serif;outline:none;">
                <option value="1.2" style="background:#1a1a1a;">Sedentary (little or no exercise)</option>
                <option value="1.375" style="background:#1a1a1a;">Lightly active (1-3 days/week)</option>
                <option value="1.55" selected style="background:#1a1a1a;">Moderately active (3-5 days/week)</option>
                <option value="1.725" style="background:#1a1a1a;">Very active (6-7 days/week)</option>
                <option value="1.9" style="background:#1a1a1a;">Extra active (physical job + exercise)</option>
            </select>
        </div>
    </div>

    {{-- Results --}}
    <div id="results-section">
        {{-- BMI --}}
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-bottom:12px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:16px;">Your Results</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                <div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:16px;padding:18px;text-align:center;">
                    <div style="font-size:11px;font-weight:700;color:#3b82f6;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">BMI</div>
                    <div id="result-bmi" style="font-size:32px;font-weight:800;color:#fff;">22.9</div>
                    <div id="result-bmi-label" style="font-size:12px;color:#10b981;margin-top:4px;font-weight:600;">Normal</div>
                </div>
                <div style="background:rgba(255,69,0,0.08);border:1px solid rgba(255,69,0,0.2);border-radius:16px;padding:18px;text-align:center;">
                    <div style="font-size:11px;font-weight:700;color:#ff4500;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">BMR</div>
                    <div id="result-bmr" style="font-size:28px;font-weight:800;color:#fff;">1,750</div>
                    <div style="font-size:12px;color:#666;margin-top:4px;">kcal/day at rest</div>
                </div>
            </div>

            {{-- TDEE --}}
            <div style="background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.05));border:1px solid rgba(16,185,129,0.25);border-radius:16px;padding:20px;text-align:center;">
                <div style="font-size:12px;font-weight:700;color:#10b981;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">TDEE (Daily Energy Need)</div>
                <div id="result-tdee" style="font-size:40px;font-weight:800;color:#fff;letter-spacing:-1px;">2,713</div>
                <div style="font-size:13px;color:#666;margin-top:4px;">calories per day</div>
            </div>
        </div>

        {{-- Goal Recommendations --}}
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-bottom:12px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Calorie Goals</h3>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <div style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.15);border-radius:14px;padding:14px;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#ef4444;">Cut (Fat Loss)</div>
                        <div style="font-size:12px;color:#555;margin-top:2px;">500 kcal deficit</div>
                    </div>
                    <div id="result-cut" style="font-size:20px;font-weight:800;color:#ef4444;">2,213</div>
                </div>
                <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);border-radius:14px;padding:14px;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#10b981;">Maintain</div>
                        <div style="font-size:12px;color:#555;margin-top:2px;">Eat at TDEE</div>
                    </div>
                    <div id="result-maintain" style="font-size:20px;font-weight:800;color:#10b981;">2,713</div>
                </div>
                <div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);border-radius:14px;padding:14px;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#3b82f6;">Bulk (Muscle Gain)</div>
                        <div style="font-size:12px;color:#555;margin-top:2px;">300 kcal surplus</div>
                    </div>
                    <div id="result-bulk" style="font-size:20px;font-weight:800;color:#3b82f6;">3,013</div>
                </div>
            </div>
        </div>

        {{-- BMI Scale --}}
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-bottom:12px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">BMI Scale</h3>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @php
                    $bmiRanges = [
                        ['label'=>'Underweight','range'=>'< 18.5','color'=>'#3b82f6'],
                        ['label'=>'Normal','range'=>'18.5 – 24.9','color'=>'#10b981'],
                        ['label'=>'Overweight','range'=>'25.0 – 29.9','color'=>'#f59e0b'],
                        ['label'=>'Obese','range'=>'≥ 30.0','color'=>'#ef4444'],
                    ];
                @endphp
                @foreach($bmiRanges as $range)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(255,255,255,0.03);border-radius:10px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:{{ $range['color'] }};flex-shrink:0;"></div>
                        <span style="font-size:13px;color:#ccc;">{{ $range['label'] }}</span>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:{{ $range['color'] }};">{{ $range['range'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Somatotype Guide --}}
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-bottom:4px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Body Type Guide</h3>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);border-radius:14px;padding:14px;">
                    <div style="font-size:14px;font-weight:700;color:#3b82f6;margin-bottom:4px;">Ectomorph (Slim)</div>
                    <div style="font-size:12px;color:#666;line-height:1.5;">Naturally lean, struggles to gain muscle. High metabolism. Needs calorie surplus and heavier compound lifts.</div>
                </div>
                <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);border-radius:14px;padding:14px;">
                    <div style="font-size:14px;font-weight:700;color:#10b981;margin-bottom:4px;">Mesomorph (Athletic)</div>
                    <div style="font-size:12px;color:#666;line-height:1.5;">Naturally muscular, responds well to training. Easy to gain and lose weight. Most versatile body type.</div>
                </div>
                <div style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.15);border-radius:14px;padding:14px;">
                    <div style="font-size:14px;font-weight:700;color:#f59e0b;margin-bottom:4px;">Endomorph (Stocky)</div>
                    <div style="font-size:12px;color:#666;line-height:1.5;">Naturally broader build, tends to store fat easily. Focus on cardio + strength. Calorie deficit for fat loss.</div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
let gender = 'male';

function setGender(g) {
    gender = g;
    const maleBtn = document.getElementById('gender-male');
    const femaleBtn = document.getElementById('gender-female');
    if (g === 'male') {
        maleBtn.style.borderColor = 'rgba(255,69,0,0.4)';
        maleBtn.style.background = 'rgba(255,69,0,0.12)';
        maleBtn.style.color = '#ff4500';
        femaleBtn.style.borderColor = 'rgba(255,255,255,0.09)';
        femaleBtn.style.background = 'rgba(255,255,255,0.04)';
        femaleBtn.style.color = '#777';
    } else {
        femaleBtn.style.borderColor = 'rgba(255,69,0,0.4)';
        femaleBtn.style.background = 'rgba(255,69,0,0.12)';
        femaleBtn.style.color = '#ff4500';
        maleBtn.style.borderColor = 'rgba(255,255,255,0.09)';
        maleBtn.style.background = 'rgba(255,255,255,0.04)';
        maleBtn.style.color = '#777';
    }
    calculate();
}

function calculate() {
    const age = parseFloat(document.getElementById('input-age').value) || 25;
    const height = parseFloat(document.getElementById('input-height').value) || 175;
    const weight = parseFloat(document.getElementById('input-weight').value) || 70;
    const activity = parseFloat(document.getElementById('input-activity').value) || 1.55;

    // BMI
    const heightM = height / 100;
    const bmi = weight / (heightM * heightM);

    // BMR (Mifflin-St Jeor)
    let bmr;
    if (gender === 'male') {
        bmr = 10 * weight + 6.25 * height - 5 * age + 5;
    } else {
        bmr = 10 * weight + 6.25 * height - 5 * age - 161;
    }

    // TDEE
    const tdee = bmr * activity;

    // BMI label
    let bmiLabel, bmiColor;
    if (bmi < 18.5) { bmiLabel = 'Underweight'; bmiColor = '#3b82f6'; }
    else if (bmi < 25) { bmiLabel = 'Normal'; bmiColor = '#10b981'; }
    else if (bmi < 30) { bmiLabel = 'Overweight'; bmiColor = '#f59e0b'; }
    else { bmiLabel = 'Obese'; bmiColor = '#ef4444'; }

    // Update DOM
    document.getElementById('result-bmi').textContent = bmi.toFixed(1);
    const bmiEl = document.getElementById('result-bmi-label');
    bmiEl.textContent = bmiLabel;
    bmiEl.style.color = bmiColor;

    document.getElementById('result-bmr').textContent = Math.round(bmr).toLocaleString();
    document.getElementById('result-tdee').textContent = Math.round(tdee).toLocaleString();
    document.getElementById('result-cut').textContent = Math.round(tdee - 500).toLocaleString();
    document.getElementById('result-maintain').textContent = Math.round(tdee).toLocaleString();
    document.getElementById('result-bulk').textContent = Math.round(tdee + 300).toLocaleString();
}

// Calculate on load
calculate();
</script>
@endsection
