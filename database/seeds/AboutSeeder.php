<?php

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'icon' => 'rabbits.png',
            'tagline' => 'Capture and Bring your Moment with Us',
            'deskripsi' => 'Rabbit Media is a digital creative service agency that established in 2015. We\'re using a various kind of tools such as Adobe Premiere Pro, Adobe After Effect, Adobe Photoshop, Corel Draw, and another professional software.',
            'visi' => 'We strive to serve the most reasonable COST, the best QUALITY in digital creative services, and also strive to serve ONE-DAY services committed to our customer satisfaction that according to our tagline :',
            'misi' => '<ol type="I"><li>To ensure the sustainable growth by developing our passionated crew and quality to accurately meet the needs of our clients.</li><li>To provide professional services and high-quality digital creative serices.</li><li>To develop strong and profound partnership with other relatable enterprises.</li></ol>'
        ]);
    }
}
