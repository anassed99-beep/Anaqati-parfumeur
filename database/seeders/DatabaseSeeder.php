<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@elixirdorient.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        // Default Site Settings
        $defaultSettings = [
            'hero_title_fr'   => "Anaqati",
            'hero_title_ar'   => "أناقتي",
            'hero_slogan_fr'  => "L'Élégance Impériale en Flacon",
            'hero_slogan_ar'  => "الفخامة الإمبراطورية في زجاجة عطر",
            'hero_desc_fr'    => "Nous sélectionnons les plus précieuses essences d'Oud, de Musc et de Rose pour concevoir des parfums d'exception.",
            'hero_desc_ar'    => "نصنع من أجود أنواع العود والمسك والورد عطوراً تروي قصصاً من التراث العريق والفخامة العصرية.",
            'hero_bg_image'   => "images/oud_majestic.png",
            'about_title_fr'  => "L'Art du Parfum Rare",
            'about_title_ar'  => "شغفنا بالعطور النادرة",
            'about_p1_fr'     => "Fondée au cœur de la grande tradition de la parfumerie orientale, la maison Elixir d'Orient élabore des créations intemporelles.",
            'about_p1_ar'     => "تأسست دار إكسير الشرق في قلب التقاليد العطرية العربية لتصنع هوية عطرية لا تُنسى.",
            'about_p2_fr'     => "Nos flacons incarnent un luxe discret et authentique, conçus pour ceux qui recherchent une signature olfactive remarquable.",
            'about_p2_ar'     => "عطورنا ليست مجرد روائح، بل هي بصمة شخصية تعبر عن الفخامة والتميز، وترافقكم في أسعد لحظاتكم.",
            'whatsapp_number' => "+212600000000",
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if (\App\Models\Perfume::count() == 0) {
            \App\Models\Perfume::create([
                'name_fr' => 'Oud Majestic',
                'name_ar' => 'عود ماجستيك',
                'description_fr' => 'Un accord mystique d\'oud boisé enrichi de notes de cuir et de vanille dorée.',
                'description_ar' => 'تناغم غامض من العود الخشبي معزز بنفحات الجلد والفانيليا الذهبية.',
                'notes_fr' => 'Oud, Cuir, Vanille, Cannelle',
                'notes_ar' => 'العود، الجلد، الفانيليا، القرفة',
                'price' => 120.00,
                'image_url' => 'images/oud_majestic.png',
                'is_featured' => true,
            ]);

            \App\Models\Perfume::create([
                'name_fr' => 'Rose Jasmin',
                'name_ar' => 'ورد الياسمين',
                'description_fr' => 'Une fraîcheur florale d\'Orient mariant la délicatesse de la rose de Damas.',
                'description_ar' => 'نضارة زهرية شرقية تجمع بين رقة الورد الدمشقي وجاذبية الياسمين الأبيض.',
                'notes_fr' => 'Rose de Damas, Jasmin Blanc, Musc Doux',
                'notes_ar' => 'الورد الدمشقي، الياسمين الأبيض، المسك الناعم',
                'price' => 95.00,
                'image_url' => 'images/rose_yasmin.png',
                'is_featured' => true,
            ]);

            \App\Models\Perfume::create([
                'name_fr' => 'Musc Impérial',
                'name_ar' => 'مسك إمبراطوري',
                'description_fr' => 'Une fragrance pure et veloutée de musc blanc royal combinée à des touches de bois de santal.',
                'description_ar' => 'رائحة نقية ومخملية من المسك الأبيض الملكي ممزوجة بلمسات من خشب الصندل والعنبر.',
                'notes_fr' => 'Musc Blanc, Bois de Santal, Ambre Gris',
                'notes_ar' => 'المسك الأبيض، خشب الصندل، العنبر الرمادي',
                'price' => 110.00,
                'image_url' => 'images/musc_imperial.png',
                'is_featured' => false,
            ]);
        }
    }
}
