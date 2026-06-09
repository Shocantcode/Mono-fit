@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Nutrition</h1>
            <p style="font-size:13px;color:#666;margin-top:4px;">{{ now()->format('l, d F') }}</p>
        </div>
        <button onclick="openMealModal()" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:10px 16px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;">+ Log Meal</button>
    </div>

    {{-- Calorie Summary --}}
    <div style="background:linear-gradient(135deg,#0d1520,#0a1a2e);border:1px solid rgba(59,130,246,0.2);border-radius:20px;padding:22px;">
        <h3 style="font-size:14px;font-weight:600;color:#666;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.5px;">Daily Calories</h3>
        <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            <div style="text-align:center;min-width:220px;">
                <div style="font-size:40px;font-weight:800;color:#3b82f6;line-height:1;">{{ $targetCalories }}</div>
                <div style="font-size:11px;color:#555;margin-top:4px;">Daily Calorie Target</div>
                <div style="font-size:12px;color:#888;margin-top:6px;">Consumed: <span style="color:#fff;font-weight:700;">{{ number_format($calories,0) }}</span> kcal</div>
                @if($goalLabel)
                    <div style="font-size:11px;color:#6ee7b7;margin-top:4px;">Goal: {{ $goalLabel }}</div>
                @endif
            </div>
            <div style="flex:1;min-width:280px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                    <span style="font-size:12px;color:#666;">{{ number_format($calories,0) }} / {{ number_format($targetCalories,0) }} kcal</span>
                    <span style="font-size:12px;color:#3b82f6;font-weight:600;">{{ min(100, round($calories / max(1, $targetCalories) * 100)) }}%</span>
                </div>
                <div style="height:8px;background:rgba(255,255,255,0.06);border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ min(100, round($calories / max(1, $targetCalories) * 100)) }}%;background:linear-gradient(90deg,#3b82f6,#6366f1);border-radius:4px;transition:width 0.5s;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:6px;">
                    <span style="font-size:11px;color:#444;">Remaining: <b style="color:#fff;">{{ number_format(max(0, $targetCalories - $calories),0) }} kcal</b></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Macros --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:16px;">Macronutrients</h3>
        @php
            $macros = [
                ['name'=>'Protein','value'=>$protein ?? 0,'goal'=> $proteinGoal ?? 0,'unit'=>'g','color'=>'#3b82f6','bg'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)'],
                ['name'=>'Carbs','value'=>$carbs ?? 0,'goal'=> $carbsGoal ?? 0,'unit'=>'g','color'=>'#f59e0b','bg'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)'],
                ['name'=>'Fat','value'=>$fat ?? 0,'goal'=> $fatGoal ?? 0,'unit'=>'g','color'=>'#ef4444','bg'=>'rgba(239,68,68,0.1)','border'=>'rgba(239,68,68,0.2)'],
                ['name'=>'Water','value'=>$water ?? 0,'goal'=> $waterGoalL ?? 0,'unit'=>'L','color'=>'#06b6d4','bg'=>'rgba(6,182,212,0.1)','border'=>'rgba(6,182,212,0.2)'],
            ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach($macros as $macro)
            @php $pct = $macro['goal'] ? min(100, round($macro['value'] / $macro['goal'] * 100)) : 0; @endphp
            <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                <div style="background:{{ $macro['bg'] }};border:1px solid {{ $macro['border'] }};border-radius:12px;padding:10px 12px;min-width:68px;text-align:center;">
                    <div style="font-size:17px;font-weight:800;color:{{ $macro['color'] }};">{{ number_format($macro['value'],1) }}</div>
                    <div style="font-size:10px;color:#555;">{{ $macro['unit'] }}</div>
                </div>
                <div style="flex:1;min-width:220px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                        <span style="font-size:13px;font-weight:600;color:#ccc;">{{ $macro['name'] }}</span>
                        <span style="font-size:12px;color:{{ $macro['color'] }};font-weight:600;">{{ $pct }}% of goal</span>
                    </div>
                    <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:3px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $macro['color'] }};border-radius:3px;"></div>
                    </div>
                    <div style="font-size:11px;color:#444;margin-top:3px;">Goal: {{ number_format($macro['goal'],1) }}{{ $macro['unit'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recipe Suggestions --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;">Recipe Suggestions</h3>
            <span style="font-size:13px;color:#aaa;">Recommended for {{ ucfirst(str_replace('_',' ', $fitnessGoal)) }}</span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;">
            @foreach($recipes as $recipe)
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:18px;overflow:hidden;">
                <div style="height:140px;overflow:hidden;"><img src="{{ $recipe->image_url }}" alt="{{ $recipe->name }}" style="width:100%;height:100%;object-fit:cover;"></div>
                <div style="padding:14px;">
                    <div style="font-size:12px;color:#888;margin-bottom:6px;">{{ ucfirst(str_replace('_',' ', $recipe->goal)) }}</div>
                    <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:10px;">{{ $recipe->name }}</div>
                    <div style="font-size:12px;color:#999;line-height:1.5;min-height:42px;">{{ $recipe->description }}</div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;">
                        <button type="button" onclick="showRecipeDetail(this.dataset.recipe)" data-recipe='@json($recipe)' style="flex:1;background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);color:#3b82f6;padding:10px 12px;border-radius:12px;font-size:12px;cursor:pointer;">View</button>
                        <button type="button" onclick="chooseRecipe(this)" data-recipe='@json($recipe)' style="flex:1;background:linear-gradient(135deg,#4f46e5,#2563eb);border:none;color:#fff;padding:10px 12px;border-radius:12px;font-size:12px;cursor:pointer;">Select</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Today's Meals --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Today's Meals</h3>
        @if(count($meals) > 0)
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($meals as $meal)
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:16px;">
                <div style="display:flex;justify-content:space-between;gap:12px;align-items:center;flex-wrap:wrap;">
                    <div style="min-width:0;flex:1;">
                        <div style="font-size:12px;color:#888;margin-bottom:4px;text-transform:capitalize;">{{ $meal['meal_type'] ?? 'Meal' }} · {{ ucfirst($meal['source'] ?? 'custom') }}</div>
                        <div style="font-size:15px;font-weight:700;color:#fff;">{{ $meal['name'] }}{{ isset($meal['grams']) ? ' (' . $meal['grams'] . 'g)' : '' }}</div>
                    </div>
                    <div style="text-align:right;min-width:100px;">
                        <div style="font-size:15px;font-weight:700;color:#ff7d1a;">{{ number_format($meal['calories'],0) }} kcal</div>
                        <div style="font-size:11px;color:#aaa;">{{ number_format($meal['protein'],1) }}P · {{ number_format($meal['carbs'],1) }}C · {{ number_format($meal['fat'],1) }}F</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:24px 0;">
            <div style="font-size:42px;margin-bottom:10px;">🍽️</div>
            <p style="font-size:14px;color:#555;">No meals logged today yet.</p>
        </div>
        @endif
    </div>

    {{-- Water Tracker --}}
    @php
        $waterProgress = $waterGoalMl ? min(100, round(($water * 1000 / $waterGoalMl) * 100)) : 0;
    @endphp
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
            <div>
                <h3 style="font-size:16px;font-weight:700;color:#fff;">Water Intake 💧</h3>
                <div style="font-size:12px;color:#888;">Daily water goal: {{ $waterGoalMl }} ml ({{ number_format($waterGoalL, 2) }} L)</div>
            </div>
            <div style="text-align:right;min-width:120px;">
                <div style="font-size:18px;font-weight:700;color:#06b6d4;">{{ number_format($water, 2) }} L</div>
                <div style="font-size:12px;color:#aaa;">{{ $waterProgress }}% complete</div>
            </div>
        </div>
        <div style="height:10px;background:rgba(255,255,255,0.06);border-radius:999px;overflow:hidden;margin-bottom:18px;">
            <div style="height:100%;width:{{ $waterProgress }}%;background:linear-gradient(90deg,#06b6d4,#22d3ee);"></div>
        </div>
        <form method="POST" action="{{ route('nutrition.water.store') }}" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;">
            @csrf
            <button type="submit" name="water_ml" value="100" style="background:rgba(6,182,212,0.1);border:1px solid rgba(6,182,212,0.25);color:#06b6d4;padding:12px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;">+100 ml</button>
            <button type="submit" name="water_ml" value="200" style="background:rgba(6,182,212,0.1);border:1px solid rgba(6,182,212,0.25);color:#06b6d4;padding:12px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;">+200 ml</button>
            <button type="submit" name="water_ml" value="500" style="background:rgba(6,182,212,0.1);border:1px solid rgba(6,182,212,0.25);color:#06b6d4;padding:12px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;">+500 ml</button>
            <div style="display:flex;gap:10px;align-items:stretch;">
                <input type="number" name="custom_water_ml" placeholder="Custom ml" min="1" style="flex:1;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:13px;outline:none;">
                <button type="submit" style="background:linear-gradient(135deg,#06b6d4,#22d3ee);border:none;color:#fff;padding:12px 16px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;">Add</button>
            </div>
        </form>
    </div>

    {{-- Nutrition Tips --}}
    <div style="background:linear-gradient(135deg,#0d1a0d,#0a1a0a);border:1px solid rgba(16,185,129,0.2);border-radius:20px;padding:18px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <div style="width:36px;height:36px;background:rgba(16,185,129,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">💡</div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#10b981;">Nutrition Tips</div>
                <div style="font-size:12px;color:#777;">Click sides to navigate through tips.</div>
            </div>
        </div>
        <div id="nutrition-tip-card" onclick="handleTipClick(event)" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:18px;min-height:120px;cursor:pointer;display:flex;align-items:center;">
            <div style="font-size:14px;color:#ddd;line-height:1.7;width:100%;" id="nutrition-tip-text"></div>
        </div>
    </div>
</div>

@if(session('success'))
<div style="position:fixed;bottom:22px;right:22px;z-index:300;background:rgba(15,23,42,0.94);color:#fff;padding:14px 18px;border-radius:16px;box-shadow:0 12px 40px rgba(0,0,0,0.25);font-size:13px;">
    {{ session('success') }}
</div>
@endif

{{-- Log Meal Modal --}}
<div id="meal-modal" style="display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.8);align-items:flex-end;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:#181818;border:1px solid rgba(255,255,255,0.1);border-radius:24px 24px 0 0;padding:28px 20px;width:100%;max-width:520px;max-height:90vh;overflow-y:auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:20px;">
            <div>
                <h3 style="font-size:18px;font-weight:700;color:#fff;margin-bottom:4px;">Log a Meal</h3>
                <div style="font-size:12px;color:#888;">Choose recipe or add a custom entry.</div>
            </div>
            <button type="button" onclick="closeMealModal()" style="background:rgba(255,255,255,0.08);border:none;color:#aaa;width:36px;height:36px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
        </div>

        <div id="meal-choice-view">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px;">
                <button type="button" onclick="showMealView('recipe')" style="background:rgba(59,130,246,0.12);border:1px solid rgba(59,130,246,0.2);color:#fff;padding:20px;border-radius:18px;font-size:14px;font-weight:700;cursor:pointer;">Recipe from App</button>
                <button type="button" onclick="showMealView('custom')" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.2);color:#fff;padding:20px;border-radius:18px;font-size:14px;font-weight:700;cursor:pointer;">Custom Food</button>
            </div>
            <p style="font-size:13px;color:#aaa;line-height:1.6;">Use app-created recipes for fast logging, or add your own diet/gym foods with grams and macros.</p>
        </div>

        <div id="meal-recipe-view" style="display:none;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div style="font-size:14px;color:#aaa;">Recipe selection</div>
                <button type="button" onclick="showMealView('choice')" style="background:transparent;border:none;color:#aaa;cursor:pointer;font-size:13px;">Back</button>
            </div>
            <div style="margin-bottom:20px;">
                <form id="recipe-select-form" method="POST" action="{{ route('nutrition.meal.store') }}">
                    @csrf
                    <input type="hidden" name="meal_source" value="recipe">
                    <input type="hidden" id="recipe_id" name="recipe_id" value="">
                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        <div style="flex:1;min-width:150px;">
                            <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Meal Type</label>
                            <select name="meal_type" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="snack">Snack</option>
                            </select>
                        </div>
                        <div style="flex:1;min-width:150px;">
                            <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Selected Recipe</label>
                            <div id="selected-recipe-name" style="min-height:52px;padding:12px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:12px;color:#fff;font-size:14px;">Pick a recipe below.</div>
                        </div>
                    </div>
                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#4f46e5,#2563eb);border:none;color:#fff;padding:14px 16px;border-radius:14px;font-size:15px;font-weight:700;cursor:pointer;margin-top:18px;">Log Recipe</button>
                </form>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;">
                @foreach($recipes as $recipe)
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:18px;overflow:hidden;">
                    <div style="height:120px;overflow:hidden;"><img src="{{ $recipe->image_url }}" alt="{{ $recipe->name }}" style="width:100%;height:100%;object-fit:cover;"></div>
                    <div style="padding:14px;">
                        <div style="font-size:13px;color:#aaa;margin-bottom:6px;">{{ ucfirst(str_replace('_',' ', $recipe->goal)) }}</div>
                        <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:8px;">{{ $recipe->name }}</div>
                        <div style="font-size:12px;color:#777;line-height:1.5;height:48px;overflow:hidden;">{{ $recipe->description }}</div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;">
                            <button type="button" onclick="showRecipeDetail(this.dataset.recipe)" data-recipe='@json($recipe)' style="flex:1;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#ddd;padding:10px 12px;border-radius:12px;font-size:12px;cursor:pointer;">Preview</button>
                            <button type="button" onclick="chooseRecipe(this)" data-recipe='@json($recipe)' style="flex:1;background:linear-gradient(135deg,#4f46e5,#2563eb);border:none;color:#fff;padding:10px 12px;border-radius:12px;font-size:12px;cursor:pointer;">Select</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div id="meal-custom-view" style="display:none;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div style="font-size:14px;color:#aaa;">Custom food entry</div>
                <button type="button" onclick="showMealView('choice')" style="background:transparent;border:none;color:#aaa;cursor:pointer;font-size:13px;">Back</button>
            </div>
            <form method="POST" action="{{ route('nutrition.meal.store') }}" style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                <input type="hidden" name="meal_source" value="custom">
                <input type="hidden" name="custom_type" id="custom_type" value="fixed">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Meal Type</label>
                        <select name="meal_type" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                            <option value="snack">Snack</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Food Source</label>
                        <select name="custom_type" id="custom-type-select" onchange="toggleCustomType(this.value)" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                            <option value="fixed">Pilih dari daftar</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div id="fixed-food-group">
                    <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Choose Food</label>
                    <select name="custom_choice" id="custom-choice" onchange="updateCustomMacros()" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        <option value="chicken_breast">Dada Ayam</option>
                        <option value="chicken_thigh">Paha Ayam</option>
                        <option value="beef_sirloin">Daging Sapi</option>
                        <option value="salmon">Salmon</option>
                        <option value="greek_yogurt">Greek Yogurt</option>
                    </select>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Gram</label>
                        <input type="number" name="custom_grams" id="custom-grams" value="100" min="10" onchange="updateCustomMacros()" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Calories</label>
                        <input type="text" id="custom-calories" readonly style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;">
                    <div>
                        <label style="font-size:12px;color:#3b82f6;display:block;margin-bottom:6px;">Protein (g)</label>
                        <input type="text" id="custom-protein" readonly style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:12px;color:#f59e0b;display:block;margin-bottom:6px;">Carbs (g)</label>
                        <input type="text" id="custom-carbs" readonly style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:12px;color:#ef4444;display:block;margin-bottom:6px;">Fat (g)</label>
                        <input type="text" id="custom-fat" readonly style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    </div>
                </div>

                <div id="custom-other-group" style="display:none;flex-direction:column;gap:14px;">
                    <div>
                        <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Food Name</label>
                        <input type="text" name="custom_name" placeholder="Write food name" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">
                        <div>
                            <label style="font-size:12px;color:#888;display:block;margin-bottom:6px;">Calories</label>
                            <input type="number" name="custom_calories" placeholder="kcal" min="1" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:12px;color:#3b82f6;display:block;margin-bottom:6px;">Protein</label>
                            <input type="number" name="custom_protein" placeholder="g" step="0.1" min="0" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">
                        <div>
                            <label style="font-size:12px;color:#f59e0b;display:block;margin-bottom:6px;">Carbs</label>
                            <input type="number" name="custom_carbs" placeholder="g" step="0.1" min="0" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:12px;color:#ef4444;display:block;margin-bottom:6px;">Fat</label>
                            <input type="number" name="custom_fat" placeholder="g" step="0.1" min="0" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                        </div>
                    </div>
                </div>

                <button type="submit" style="width:100%;background:linear-gradient(135deg,#10b981,#22c55e);border:none;color:#fff;padding:14px 16px;border-radius:14px;font-size:15px;font-weight:700;cursor:pointer;">Log Custom Meal</button>
            </form>
        </div>
    </div>
</div>

{{-- Recipe Detail Modal --}}
<div id="recipe-detail-modal" style="display:none;position:fixed;inset:0;z-index:220;background:rgba(0,0,0,0.85);align-items:center;justify-content:center;backdrop-filter:blur(6px);">
    <div style="background:#121212;border:1px solid rgba(255,255,255,0.1);border-radius:24px;padding:24px;width:100%;max-width:560px;max-height:88vh;overflow-y:auto;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:18px;">
            <div>
                <div id="recipe-detail-goal" style="font-size:12px;color:#10b981;margin-bottom:6px;">Recipe</div>
                <h3 id="recipe-detail-name" style="font-size:22px;font-weight:800;color:#fff;margin:0;">Recipe Name</h3>
            </div>
            <button type="button" onclick="closeRecipeDetail()" style="background:rgba(255,255,255,0.08);border:none;color:#aaa;width:36px;height:36px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
        </div>
        <div style="border-radius:18px;overflow:hidden;margin-bottom:18px;"><img id="recipe-detail-image" src="https://via.placeholder.com/560x300?text=Recipe+Preview" alt="Recipe preview" style="width:100%;height:240px;object-fit:cover;"></div>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:18px;">
            <div style="flex:1;min-width:120px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:14px;">
                <div style="font-size:12px;color:#888;">Calories</div>
                <div id="recipe-detail-calories" style="font-size:18px;font-weight:700;color:#fff;">0 kcal</div>
            </div>
            <div style="flex:1;min-width:120px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:14px;">
                <div style="font-size:12px;color:#888;">Protein</div>
                <div id="recipe-detail-protein" style="font-size:18px;font-weight:700;color:#3b82f6;">0 g</div>
            </div>
            <div style="flex:1;min-width:120px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:14px;">
                <div style="font-size:12px;color:#888;">Carbs</div>
                <div id="recipe-detail-carbs" style="font-size:18px;font-weight:700;color:#f59e0b;">0 g</div>
            </div>
            <div style="flex:1;min-width:120px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:14px;">
                <div style="font-size:12px;color:#888;">Fat</div>
                <div id="recipe-detail-fat" style="font-size:18px;font-weight:700;color:#ef4444;">0 g</div>
            </div>
        </div>
        <div style="margin-bottom:18px;">
            <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:10px;">Ingredients</div>
            <ul id="recipe-detail-ingredients" style="padding-left:18px;color:#ddd;font-size:13px;line-height:1.7;"></ul>
        </div>
        <div style="margin-bottom:22px;">
            <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:10px;">Steps</div>
            <ol id="recipe-detail-steps" style="padding-left:18px;color:#ddd;font-size:13px;line-height:1.7;"></ol>
        </div>
        <button type="button" onclick="closeRecipeDetail()" style="width:100%;background:linear-gradient(135deg,#4f46e5,#2563eb);border:none;color:#fff;padding:14px 16px;border-radius:16px;font-size:15px;font-weight:700;cursor:pointer;">Close</button>
    </div>
</div>

<script>
    const tips = [
        'Makan protein pada 30 menit setelah latihan untuk membantu pemulihan otot.',
        'Gunakan biji-bijian utuh dan sayuran warna-warni untuk energi stabil sepanjang hari.',
        'Minum 100 ml air setiap jam untuk menjaga hidrasi selama aktivitas intens.',
        'Fokus pada makanan padat nutrisi dan kurangi gula tambahan saat diet.',
        'Prioritaskan tidur 7-8 jam setiap malam untuk mendukung komposisi tubuh dan pemulihan.',
    ];
    let tipIndex = 0;
    let tipInterval = null;

    function showTip(index) {
        tipIndex = (index + tips.length) % tips.length;
        document.getElementById('nutrition-tip-text').textContent = tips[tipIndex];
    }

    function startTipRotation() {
        tipInterval = setInterval(() => {
            showTip(tipIndex + 1);
        }, 5000);
    }

    function resetTipTimer() {
        clearInterval(tipInterval);
        startTipRotation();
    }

    function handleTipClick(event) {
        const cardWidth = event.currentTarget.offsetWidth;
        const clickX = event.clientX - event.currentTarget.getBoundingClientRect().left;
        const isRightSide = clickX > cardWidth / 2;

        if (isRightSide) {
            showTip(tipIndex + 1);
        } else {
            showTip(tipIndex - 1);
        }
        resetTipTimer();
    }

    function showMealView(view) {
        document.getElementById('meal-choice-view').style.display = view === 'choice' ? 'block' : 'none';
        document.getElementById('meal-recipe-view').style.display = view === 'recipe' ? 'block' : 'none';
        document.getElementById('meal-custom-view').style.display = view === 'custom' ? 'block' : 'none';
        if (view === 'custom') {
            toggleCustomType(document.getElementById('custom-type-select').value || 'fixed');
        }
    }

    function openMealModal() {
        document.getElementById('meal-modal').style.display = 'flex';
        showMealView('choice');
    }

    function closeMealModal() {
        document.getElementById('meal-modal').style.display = 'none';
    }

    function showRecipeDetail(recipeJson) {
        const recipe = JSON.parse(recipeJson);
        document.getElementById('recipe-detail-goal').textContent = recipe.goal.replace('_', ' ').toUpperCase();
        document.getElementById('recipe-detail-name').textContent = recipe.name;
        document.getElementById('recipe-detail-image').src = recipe.image_url || 'https://via.placeholder.com/560x300?text=Recipe+Preview';
        document.getElementById('recipe-detail-calories').textContent = recipe.calories + ' kcal';
        document.getElementById('recipe-detail-protein').textContent = recipe.protein + ' g';
        document.getElementById('recipe-detail-carbs').textContent = recipe.carbs + ' g';
        document.getElementById('recipe-detail-fat').textContent = recipe.fat + ' g';

        const ingredientsEl = document.getElementById('recipe-detail-ingredients');
        ingredientsEl.innerHTML = '';
        (recipe.ingredients || []).forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            ingredientsEl.appendChild(li);
        });

        const stepsEl = document.getElementById('recipe-detail-steps');
        stepsEl.innerHTML = '';
        (recipe.steps || []).forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            stepsEl.appendChild(li);
        });

        document.getElementById('recipe-detail-modal').style.display = 'flex';
    }

    function closeRecipeDetail() {
        document.getElementById('recipe-detail-modal').style.display = 'none';
    }

    function chooseRecipe(button) {
        const recipe = JSON.parse(button.dataset.recipe);
        document.getElementById('recipe_id').value = recipe.id;
        document.getElementById('selected-recipe-name').textContent = recipe.name;
        showMealView('recipe');
    }

    const customFoods = {
        chicken_breast: { calories: 165, protein: 31, carbs: 0, fat: 3.6 },
        chicken_thigh: { calories: 209, protein: 25, carbs: 0, fat: 10 },
        beef_sirloin: { calories: 217, protein: 27, carbs: 0, fat: 11 },
        salmon: { calories: 208, protein: 20, carbs: 0, fat: 13 },
        greek_yogurt: { calories: 59, protein: 10, carbs: 4, fat: 0.4 },
    };

    function toggleCustomType(value) {
        document.getElementById('custom_type').value = value;
        document.getElementById('custom-other-group').style.display = value === 'other' ? 'flex' : 'none';
        document.getElementById('fixed-food-group').style.display = value === 'fixed' ? 'block' : 'none';
        updateCustomMacros();
    }

    function updateCustomMacros() {
        const type = document.getElementById('custom_type').value;
        const grams = Number(document.getElementById('custom-grams').value) || 0;
        if (type === 'fixed') {
            const choice = document.getElementById('custom-choice').value;
            const food = customFoods[choice] || { calories: 0, protein: 0, carbs: 0, fat: 0 };
            const factor = grams / 100;
            document.getElementById('custom-calories').value = (food.calories * factor).toFixed(1);
            document.getElementById('custom-protein').value = (food.protein * factor).toFixed(1);
            document.getElementById('custom-carbs').value = (food.carbs * factor).toFixed(1);
            document.getElementById('custom-fat').value = (food.fat * factor).toFixed(1);
        } else {
            document.getElementById('custom-calories').value = '';
            document.getElementById('custom-protein').value = '';
            document.getElementById('custom-carbs').value = '';
            document.getElementById('custom-fat').value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        showTip(0);
        startTipRotation();
        toggleCustomType('fixed');
    });
</script>

@endsection
