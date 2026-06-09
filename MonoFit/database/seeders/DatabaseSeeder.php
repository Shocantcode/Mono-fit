<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run admin seeder
        $this->call(AdminSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Recipe::unguard();

        Recipe::insert([
            [
                'name' => 'Lean Chicken Bowl',
                'goal' => 'fat_loss',
                'description' => 'Protein-rich bowl with lean chicken, greens, and slow carbs for a fat loss meal plan.',
                'image_url' => 'https://via.placeholder.com/320x220?text=Lean+Chicken+Bowl',
                'ingredients' => json_encode([
                    '150g ayam dada panggang',
                    '½ cup quinoa matang',
                    '100g brokoli kukus',
                    '1 sdm minyak zaitun',
                    'Lemon dan lada hitam',
                ]),
                'steps' => json_encode([
                    'Panaskan oven lalu panggang dada ayam dengan garam dan lada.',
                    'Rebus quinoa sampai empuk dan kukus brokoli.',
                    'Campurkan semua bahan dalam mangkuk besar.',
                    'Tambahkan minyak zaitun dan perasan lemon sebelum disajikan.',
                ]),
                'calories' => 420,
                'protein' => 38,
                'carbs' => 40,
                'fat' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Turkey & Veggie Stir Fry',
                'goal' => 'fat_loss',
                'description' => 'Low-fat stir fry with turkey, colorful vegetables, and a light ginger soy sauce.',
                'image_url' => 'https://via.placeholder.com/320x220?text=Turkey+Stir+Fry',
                'ingredients' => json_encode([
                    '120g kalkun cincang',
                    '1 wortel iris',
                    '100g paprika merah',
                    '1 cup jamur',
                    '1 sdm kecap rendah sodium',
                ]),
                'steps' => json_encode([
                    'Tumiskan kalkun sampai matang dan sisihkan.',
                    'Tumis sayuran dengan sedikit minyak sampai layu.',
                    'Masukkan kalkun kembali dan tambahkan kecap.',
                    'Aduk rata lalu angkat saat bumbu meresap.',
                ]),
                'calories' => 370,
                'protein' => 34,
                'carbs' => 28,
                'fat' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Balanced Grain Plate',
                'goal' => 'maintenance',
                'description' => 'Seimbang antara karbohidrat, protein, dan lemak untuk energi stabil di siang hari.',
                'image_url' => 'https://via.placeholder.com/320x220?text=Balanced+Grain+Plate',
                'ingredients' => json_encode([
                    '100g nasi merah',
                    '120g ayam panggang',
                    '50g kacang hijau',
                    '1/2 alpukat',
                    'Segenggam sayur campur',
                ]),
                'steps' => json_encode([
                    'Masak nasi merah sampai empuk.',
                    'Panggang ayam dengan bumbu favorit.',
                    'Siapkan sayur dan alpukat di piring.',
                    'Susun nasi, ayam, dan sayuran lalu sajikan.',
                ]),
                'calories' => 550,
                'protein' => 36,
                'carbs' => 58,
                'fat' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Salmon Power Salad',
                'goal' => 'maintenance',
                'description' => 'Salad kaya omega-3 dengan salmon, kacang, dan sayuran hijau untuk pemulihan otot.',
                'image_url' => 'https://via.placeholder.com/320x220?text=Salmon+Power+Salad',
                'ingredients' => json_encode([
                    '120g salmon panggang',
                    '100g bayam',
                    '30g kacang almond',
                    'Tomat ceri',
                    '1 sdm minyak zaitun',
                ]),
                'steps' => json_encode([
                    'Panggang salmon sampai matang sempurna.',
                    'Siapkan bayam dan potongan tomat dalam mangkuk.',
                    'Taburkan almond dan tambahkan salmon.',
                    'Sirami minyak zaitun dan aduk ringan.',
                ]),
                'calories' => 520,
                'protein' => 32,
                'carbs' => 16,
                'fat' => 32,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beef Muscle Bowl',
                'goal' => 'muscle_gain',
                'description' => 'High-protein bowl dengan daging sapi panggang dan karbo kompleks untuk pertumbuhan otot.',
                'image_url' => 'https://via.placeholder.com/320x220?text=Beef+Muscle+Bowl',
                'ingredients' => json_encode([
                    '150g daging sapi sirloin',
                    '100g ubi jalar',
                    '70g brokoli',
                    '1 sdm minyak zaitun',
                    'Bumbu lada hitam',
                ]),
                'steps' => json_encode([
                    'Panggang daging sapi dengan bumbu sederhana.',
                    'Panggang ubi jalar sampai empuk.',
                    'Kukus brokoli sebentar.',
                    'Susun semuanya dalam mangkuk dan sajikan.',
                ]),
                'calories' => 690,
                'protein' => 48,
                'carbs' => 56,
                'fat' => 28,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quinoa Chicken Wrap',
                'goal' => 'muscle_gain',
                'description' => 'Wrap tinggi protein yang mudah dibawa dengan quinoa, ayam, dan saus ringan.',
                'image_url' => 'https://via.placeholder.com/320x220?text=Quinoa+Chicken+Wrap',
                'ingredients' => json_encode([
                    '1 tortilla gandum utuh',
                    '100g quinoa matang',
                    '120g ayam suwir',
                    'Daun selada',
                    'Saus yogurt rendah lemak',
                ]),
                'steps' => json_encode([
                    'Panaskan tortilla dan isi dengan quinoa.',
                    'Tambahkan ayam suwir dan selada.',
                    'Sirami saus yogurt secukupnya.',
                    'Gulung wrap erat dan potong dua.',
                ]),
                'calories' => 620,
                'protein' => 40,
                'carbs' => 62,
                'fat' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->call(ExerciseSeeder::class);
    }
}
