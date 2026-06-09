@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
    <div>
        <h1 style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Exercise Library</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">Explore exercises with GIF previews and filter by category.</p>
    </div>

    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;display:flex;flex-direction:column;gap:18px;">
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
            <input id="exercise-search" type="text" placeholder="Search exercises..." value="{{ $search ?? '' }}" style="flex:1;min-width:220px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:13px;padding:13px 14px;color:#fff;font-size:14px;font-family:'Figtree',sans-serif;outline:none;" />
            <button type="button" onclick="filterExercises()" style="background:linear-gradient(135deg,#ff4500,#ff6a00);border:none;color:#fff;padding:13px 18px;border-radius:13px;font-size:14px;cursor:pointer;">Search</button>
        </div>

        <div id="category-buttons" style="display:flex;flex-wrap:wrap;gap:10px;">
            <button type="button" class="category-button active" data-category="All" style="border:none;background:rgba(255,255,255,0.05);color:#fff;padding:10px 16px;border-radius:999px;cursor:pointer;font-size:13px;">All</button>
            @foreach($categories as $category)
                <button type="button" class="category-button" data-category="{{ $category }}" style="border:none;background:rgba(255,255,255,0.05);color:#fff;padding:10px 16px;border-radius:999px;cursor:pointer;font-size:13px;">{{ $category }}</button>
            @endforeach
        </div>

        <div id="exercise-results" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;">
            @foreach($exercises as $exercise)
                <div class="exercise-card" data-name="{{ strtolower($exercise->name) }}" data-category="{{ $exercise->category }}" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:20px;overflow:hidden;">
                    <div style="position:relative;height:160px;overflow:hidden;">
                        <img src="{{ asset(str_replace(' ', '%20', $exercise->image_path)) }}" alt="{{ $exercise->name }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                        <div style="position:absolute;left:12px;top:12px;background:rgba(0,0,0,0.45);padding:6px 10px;border-radius:999px;font-size:12px;color:#fff;">{{ $exercise->category }}</div>
                    </div>
                    <div style="padding:16px;">
                        <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:6px;">{{ $exercise->name }}</div>
                        <div style="font-size:12px;color:#888;line-height:1.5;height:42px;overflow:hidden;">{{ $exercise->description }}</div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:12px;color:#aaa;">
                            <span>{{ $exercise->equipment }}</span>
                            <span>{{ $exercise->difficulty }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const exerciseSearch = document.getElementById('exercise-search');
    const categoryButtons = document.querySelectorAll('.category-button');
    const exerciseCards = document.querySelectorAll('.exercise-card');

    function filterExercises() {
        const term = exerciseSearch.value.toLowerCase();
        const activeCategory = document.querySelector('.category-button.active')?.dataset.category || 'All';

        exerciseCards.forEach(card => {
            const name = card.dataset.name;
            const category = card.dataset.category;
            const matchesSearch = name.includes(term);
            const matchesCategory = activeCategory === 'All' || category === activeCategory;
            card.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
        });
    }

    exerciseSearch.addEventListener('input', filterExercises);

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            filterExercises();
        });
    });

    filterExercises();
</script>
@endsection
