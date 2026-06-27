<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;
use App\Models\NewsArticle;
use App\Models\Event;
use App\Models\Member;
use App\Models\GalleryPhoto;
use App\Models\GalleryAlbum;
use App\Models\BannerImage;
use App\Models\Package;
use Carbon\Carbon;

class CparcSeeder extends Seeder
{
    public function run(): void
    {
        \Schema::disableForeignKeyConstraints();
        // ── Banner Images ──────────────────────────────────────────────
        BannerImage::truncate();
        $bannerFiles = ['event_1.jpeg','event_11.jpeg','event_12.jpeg','event_13.jpeg','event_14.jpeg','event_15.jpeg'];
        foreach ($bannerFiles as $i => $file) {
            BannerImage::create([
                'path'       => 'images/club/' . $file,
                'caption'    => 'Chittagong Port Republic Club',
                'sort_order' => $i,
                'is_active'  => true,
            ]);
        }

        // ── Notices ────────────────────────────────────────────────────
        Notice::truncate();
        $notices = [
            ['title' => 'Annual General Meeting 2025 – Notice to All Members',
             'title_bn' => 'বার্ষিক সাধারণ সভা ২০২৫ – সকল সদস্যদের প্রতি বিজ্ঞপ্তি',
             'type' => 'general', 'is_new' => true, 'days' => 2],
            ['title' => 'Tender Notice: Renovation of Club Swimming Pool',
             'title_bn' => 'দরপত্র বিজ্ঞপ্তি: ক্লাব সুইমিং পুল সংস্কার',
             'type' => 'tender', 'is_new' => true, 'days' => 5],
            ['title' => 'Recruitment Notice: Security Guard (2 Posts)',
             'title_bn' => 'নিয়োগ বিজ্ঞপ্তি: নিরাপত্তা প্রহরী (২টি পদ)',
             'type' => 'recruitment', 'is_new' => true, 'days' => 7],
            ['title' => 'Club Library Opening Hours – Revised Schedule',
             'title_bn' => 'ক্লাব লাইব্রেরি খোলার সময়সূচি – সংশোধিত',
             'type' => 'general', 'is_new' => false, 'days' => 14],
            ['title' => 'Eid-ul-Adha Special Dinner Registration Open',
             'title_bn' => 'ঈদুল আযহা বিশেষ ডিনার নিবন্ধন শুরু',
             'type' => 'general', 'is_new' => false, 'days' => 20],
            ['title' => 'Tender Notice: Catering Contract 2025-2026',
             'title_bn' => 'দরপত্র বিজ্ঞপ্তি: ক্যাটারিং চুক্তি ২০২৫-২০২৬',
             'type' => 'tender', 'is_new' => false, 'days' => 30],
            ['title' => 'Notice: Renewal of Club Membership – 2025',
             'title_bn' => 'বিজ্ঞপ্তি: ক্লাব সদস্যপদ নবায়ন – ২০২৫',
             'type' => 'general', 'is_new' => false, 'days' => 45],
        ];
        foreach ($notices as $n) {
            Notice::create([
                'title'        => $n['title'],
                'title_bn'     => $n['title_bn'],
                'slug'         => \Str::slug($n['title']) . '-' . uniqid(),
                'content'      => "This is the official notice regarding: {$n['title']}\n\nAll members are requested to take note. For details contact the club office (Sun–Thu, 9AM–5PM).\n\nBy order of the General Secretary,\nChittagong Port Republic Club",
                'content_bn'   => "এই বিজ্ঞপ্তিটি সংক্রান্ত: {$n['title_bn']}\n\nসকল সদস্যদের এই ঘোষণাটি নোট করতে অনুরোধ করা হচ্ছে। বিস্তারিত জানতে ক্লাব অফিসে যোগাযোগ করুন (রবি–বৃহঃ, সকাল ৯টা–বিকাল ৫টা)।\n\nসাধারণ সম্পাদকের আদেশক্রমে,\nচট্টগ্রাম বন্দর রিপাবলিক ক্লাব",
                'type'         => $n['type'],
                'is_new'       => $n['is_new'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays($n['days']),
            ]);
        }

        // ── News ───────────────────────────────────────────────────────
        NewsArticle::truncate();
        $news = [
            ['title' => 'CPRC Wins Best Port Club Award 2025 at National Level',
             'title_bn' => 'জাতীয় পর্যায়ে সেরা বন্দর ক্লাব পুরস্কার ২০২৫ পেল সিপিআরসি', 'days' => 3],
            ['title' => 'Annual Sports Week 2025 Concludes with Record Participation',
             'title_bn' => 'রেকর্ড অংশগ্রহণে শেষ হলো বার্ষিক ক্রীড়া সপ্তাহ ২০২৫', 'days' => 10],
            ['title' => 'New Swimming Pool Complex Inaugurated by Port Chairman',
             'title_bn' => 'বন্দর চেয়ারম্যান কর্তৃক নতুন সুইমিং পুল কমপ্লেক্সের উদ্বোধন', 'days' => 18],
            ['title' => 'CPRC Hosts Inter-Port Cultural Festival, 500+ Attend',
             'title_bn' => 'আন্তঃবন্দর সাংস্কৃতিক উৎসবের আয়োজন করল সিপিআরসি, ৫০০+ উপস্থিত', 'days' => 25],
            ['title' => 'Club Badminton Team Reaches National Finals',
             'title_bn' => 'জাতীয় ফাইনালে পৌঁছাল ক্লাব ব্যাডমিন্টন দল', 'days' => 35],
            ['title' => 'Eid Reunion Dinner 2025: A Night of Celebration',
             'title_bn' => 'ঈদ পুনর্মিলনী ডিনার ২০২৫: উৎসবের এক রাত', 'days' => 50],
        ];
        foreach ($news as $item) {
            NewsArticle::create([
                'title'        => $item['title'],
                'title_bn'     => $item['title_bn'],
                'slug'         => \Str::slug($item['title']) . '-' . uniqid(),
                'content'      => "The Chittagong Port Republic Club is proud to announce: {$item['title']}.\n\nThis marks a significant milestone for our club. The event was attended by senior officials of Chittagong Port Authority, distinguished guests, and members who have consistently contributed to CPRC's excellence.\n\nFor more information, contact the club secretariat.",
                'content_bn'   => "চট্টগ্রাম বন্দর রিপাবলিক ক্লাব গর্বের সাথে ঘোষণা করছে: {$item['title_bn']}।\n\nএটি আমাদের ক্লাবের জন্য একটি গুরুত্বপূর্ণ মাইলফলক। অনুষ্ঠানে চট্টগ্রাম বন্দর কর্তৃপক্ষের ঊর্ধ্বতন কর্মকর্তা, বিশিষ্ট অতিথি ও ক্লাব সদস্যরা উপস্থিত ছিলেন।\n\nবিস্তারিত জানতে ক্লাব সচিবালয়ে যোগাযোগ করুন।",
                'is_published' => true,
                'published_at' => Carbon::now()->subDays($item['days']),
            ]);
        }

        // ── Events ─────────────────────────────────────────────────────
        Event::truncate();
        $events = [
            ['title' => 'Annual General Meeting 2025', 'title_bn' => 'বার্ষিক সাধারণ সভা ২০২৫',
             'date' => 15, 'venue' => 'Main Auditorium, CPRC', 'venue_bn' => 'প্রধান অডিটোরিয়াম, সিপিআরসি', 'future' => true],
            ['title' => 'Eid-ul-Adha Special Dinner & Cultural Programme', 'title_bn' => 'ঈদুল আযহা বিশেষ ডিনার ও সাংস্কৃতিক অনুষ্ঠান',
             'date' => 30, 'venue' => 'Club Banquet Hall', 'venue_bn' => 'ক্লাব ব্যাঙ্কোয়েট হল', 'future' => true],
            ['title' => 'Independence Day Celebration & Sports Meet', 'title_bn' => 'স্বাধীনতা দিবস উদযাপন ও ক্রীড়া প্রতিযোগিতা',
             'date' => 45, 'venue' => 'CPRC Sports Ground', 'venue_bn' => 'সিপিআরসি ক্রীড়া মাঠ', 'future' => true],
            ['title' => 'Inter-Port Table Tennis Championship', 'title_bn' => 'আন্তঃবন্দর টেবিল টেনিস চ্যাম্পিয়নশিপ',
             'date' => 60, 'venue' => 'Club Indoor Stadium', 'venue_bn' => 'ক্লাব ইনডোর স্টেডিয়াম', 'future' => true],
            ['title' => 'Annual Sports Week 2025', 'title_bn' => 'বার্ষিক ক্রীড়া সপ্তাহ ২০২৫',
             'date' => 10, 'venue' => 'CPRC Sports Complex', 'venue_bn' => 'সিপিআরসি ক্রীড়া কমপ্লেক্স', 'future' => false],
            ['title' => 'Victory Day Football Tournament', 'title_bn' => 'বিজয় দিবস ফুটবল টুর্নামেন্ট',
             'date' => 40, 'venue' => 'CPRC Football Field', 'venue_bn' => 'সিপিআরসি ফুটবল মাঠ', 'future' => false],
            ['title' => 'New Year Gala Dinner 2025', 'title_bn' => 'নববর্ষ গালা ডিনার ২০২৫',
             'date' => 80, 'venue' => 'Club Roof Garden', 'venue_bn' => 'ক্লাব রুফ গার্ডেন', 'future' => false],
        ];
        foreach ($events as $ev) {
            $date = $ev['future'] ? Carbon::now()->addDays($ev['date']) : Carbon::now()->subDays($ev['date']);
            Event::create([
                'title'         => $ev['title'],
                'title_bn'      => $ev['title_bn'],
                'slug'          => \Str::slug($ev['title']) . '-' . uniqid(),
                'description'   => "Join us for {$ev['title']} — a special occasion for all CPRC members and their families.\n\nVenue: {$ev['venue']}\nTime: 6:00 PM onwards\n\nAll members are cordially invited. Seating is limited — early registration is encouraged.",
                'description_bn'=> "আমাদের সাথে যোগ দিন {$ev['title_bn']} অনুষ্ঠানে — সকল সিপিআরসি সদস্য ও তাদের পরিবারের জন্য বিশেষ অনুষ্ঠান।\n\nভেন্যু: {$ev['venue_bn']}\nসময়: সন্ধ্যা ৬টা থেকে\n\nসকল সদস্যকে সাদরে আমন্ত্রণ জানানো হচ্ছে।",
                'event_date'    => $date->toDateString(),
                'time'          => '6:00 PM',
                'venue'         => $ev['venue'],
                'venue_bn'      => $ev['venue_bn'],
                'is_published'  => true,
            ]);
        }

        // ── Members (Real names from directory) ────────────────────────
        Member::truncate();
        $members = [
            // President
            ['name' => 'Rafiul Alam',              'name_bn' => 'রাফিউল আলম',
             'designation' => 'President',          'designation_bn' => 'সভাপতি',            'sort' => 1],
            // General Secretary
            ['name' => 'Md. Faruk Hasan Chowdhury','name_bn' => 'মোঃ ফারুক হাসান চৌধুরী',
             'designation' => 'General Secretary',  'designation_bn' => 'সাধারণ সম্পাদক',   'sort' => 2],
            // Vice Presidents
            ['name' => 'Mohammad Azizul Mowla',    'name_bn' => 'মোহাম্মদ আজিজুল মওলা',
             'designation' => 'Vice President – 1', 'designation_bn' => 'সহ-সভাপতি – ১',    'sort' => 3],
            ['name' => 'Md. Anowarul Islam',        'name_bn' => 'মোঃ আনোয়ারুল ইসলাম',
             'designation' => 'Vice President – 2', 'designation_bn' => 'সহ-সভাপতি – ২',    'sort' => 4],
            // Joint Secretaries
            ['name' => 'Md. Razibul Islam Bhuiya', 'name_bn' => 'মোঃ রাজিবুল ইসলাম ভূঁইয়া',
             'designation' => 'Joint Secretary – 1','designation_bn' => 'যুগ্ম সম্পাদক – ১', 'sort' => 5],
            ['name' => 'Md. Azizul Hakim',          'name_bn' => 'মোঃ আজিজুল হাকিম',
             'designation' => 'Joint Secretary – 2','designation_bn' => 'যুগ্ম সম্পাদক – ২', 'sort' => 6],
            // Treasurer
            ['name' => 'Md. Mostafizur Rahman',    'name_bn' => 'মোঃ মোস্তাফিজুর রহমান',
             'designation' => 'Treasurer',          'designation_bn' => 'কোষাধ্যক্ষ',        'sort' => 7],
            // Office Secretary
            ['name' => 'Mahmudul Islam',            'name_bn' => 'মাহমুদুল ইসলাম',
             'designation' => 'Office Secretary',   'designation_bn' => 'দপ্তর সম্পাদক',    'sort' => 8],
            // Publicity Secretary
            ['name' => 'Md. Salauddin',             'name_bn' => 'মোঃ সালাউদ্দিন',
             'designation' => 'Publicity Secretary','designation_bn' => 'প্রচার ও প্রকাশনা সম্পাদক','sort' => 9],
            // Sports Secretary
            ['name' => 'Asif Chowdhury',            'name_bn' => 'আসিফ চৌধুরী',
             'designation' => 'Sports Secretary',   'designation_bn' => 'ক্রীড়া সম্পাদক',  'sort' => 10],
            // Literary & Cultural Secretary
            ['name' => 'Md. Hanif',                 'name_bn' => 'মোঃ হানিফ',
             'designation' => 'Cultural Secretary', 'designation_bn' => 'সাহিত্য ও সাংস্কৃতিক সম্পাদক','sort' => 11],
            // Women Affairs Secretary
            ['name' => 'Tahmina Amin',              'name_bn' => 'তাহমিনা আমিন',
             'designation' => 'Women Affairs Secretary','designation_bn' => 'মহিলা বিষয়ক সম্পাদক','sort' => 12],
            // Executive Members
            ['name' => 'Sajid Harun',               'name_bn' => 'সাজিদ হারুন',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 13],
            ['name' => 'Md. Omar Faruk',             'name_bn' => 'মোঃ ওমর ফারুক',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 14],
            ['name' => 'Md. Zahirul Islam',          'name_bn' => 'মোঃ জহিরুল ইসলাম',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 15],
            ['name' => 'Binoy Bhushan Das',          'name_bn' => 'বিনয় ভূষণ দাশ',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 16],
            ['name' => 'Md. Nuruddin',               'name_bn' => 'মোঃ নুরুদ্দিন',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 17],
            ['name' => 'Md. Akbar Hossain Patwary', 'name_bn' => 'মোঃ আকবর হোসেন পাটোয়ারী',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 18],
            ['name' => 'Md. Mojahel Haq',            'name_bn' => 'মোঃ মোজাহেল হক',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 19],
            ['name' => 'Md. Anowar Hossain',         'name_bn' => 'মোঃ আনোয়ার হোসাইন',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 20],
            ['name' => 'Mohammad Mojahel Haq',       'name_bn' => 'মোহাম্মদ মোজাহেল হক',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 21],
            ['name' => 'Md. Anowar Hosen',           'name_bn' => 'মোঃ আনোয়ার হোসেন',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 22],
            ['name' => 'Sheikh Md. Omar Faruk',      'name_bn' => 'শেখ মোঃ ওমর ফারুক',
             'designation' => 'Executive Member',   'designation_bn' => 'কার্যকরী সদস্য',   'sort' => 23],
        ];
        foreach ($members as $m) {
            Member::create([
                'name'         => $m['name'],
                'name_bn'      => $m['name_bn'],
                'designation'  => $m['designation'],
                'designation_bn'=> $m['designation_bn'],
                'type'         => 'executive',
                'sort_order'   => $m['sort'],
                'is_published' => true,
                'phone'        => '+880-31-' . rand(2500000, 2599999),
                'email'        => strtolower(str_replace(' ', '.', explode(' ', $m['name'])[count(explode(' ', $m['name']))-1])) . '@cpa.gov.bd',
            ]);
        }

        // ── Gallery ────────────────────────────────────────────────────
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        GalleryPhoto::truncate();
        GalleryAlbum::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $album = GalleryAlbum::create([
            'name'         => 'Club Events 2025',
            'slug'         => 'club-events-2025',
            'is_published' => true,
        ]);

        $galleryFiles = [
            'event_1.jpeg','event_7.jpeg','event_8.jpeg','event_9.jpeg',
            'event_11.jpeg','event_12.jpeg','event_13.jpeg','event_14.jpeg',
            'event_15.jpeg','event_16.jpeg','event_17.jpeg','event_19.jpeg',
            'event_32.jpeg','event_33.jpeg','event_44.jpeg','event_banner.jpeg',
        ];
        foreach ($galleryFiles as $i => $filename) {
            if (file_exists(public_path("images/club/{$filename}"))) {
                GalleryPhoto::create([
                    'gallery_album_id' => $album->id,
                    'path'             => "images/club/{$filename}",
                    'caption'          => 'CPRC Club Event',
                    'sort_order'       => $i + 1,
                    'is_published'     => true,
                ]);
            }
        }

        // Add venue photos
        $venueAlbum = GalleryAlbum::create([
            'name'         => 'Club Venue & Facilities',
            'slug'         => 'club-venue-facilities',
            'is_published' => true,
        ]);
        for ($v = 1; $v <= 10; $v++) {
            $vf = "venue_{$v}.jpeg";
            if (file_exists(public_path("images/club/{$vf}"))) {
                GalleryPhoto::create([
                    'gallery_album_id' => $venueAlbum->id,
                    'path'             => "images/club/{$vf}",
                    'caption'          => 'CPRC Venue',
                    'sort_order'       => $v,
                    'is_published'     => true,
                ]);
            }
        }

        // ── Packages ───────────────────────────────────────────────────
        Package::truncate();
        $packages = [
            [
                'name'           => 'Half Day Package',
                'name_bn'        => 'হাফ ডে প্যাকেজ',
                'slug'           => 'half-day-6-hours',
                'duration_hours' => 6,
                'duration_label' => '6 Hours',
                'duration_label_bn' => '৬ ঘণ্টা',
                'price'          => 30000.00,
                'price_note'     => 'Starting from',
                'description'    => 'Perfect for small gatherings, morning ceremonies, afternoon receptions, or evening cultural programmes. Includes access to the main hall with basic seating for up to 300 guests.',
                'description_bn' => 'ছোট অনুষ্ঠান, সকালের অনুষ্ঠান, বিকালের রিসেপশন বা সন্ধ্যার সাংস্কৃতিক অনুষ্ঠানের জন্য আদর্শ। সর্বোচ্চ ৩০০ অতিথির জন্য মূল হলে প্রবেশাধিকার সহ।',
                'features'       => [
                    'Main Hall Access (up to 300 guests)',
                    'Basic Stage & Podium Setup',
                    '2 Dressing Rooms',
                    'Parking Facility',
                    'Generator Backup',
                    'Security Personnel',
                    'Washroom Facilities',
                ],
                'features_bn'    => [
                    'মূল হল (সর্বোচ্চ ৩০০ অতিথি)',
                    'মঞ্চ ও পোডিয়াম সেটআপ',
                    '২টি ড্রেসিং রুম',
                    'পার্কিং সুবিধা',
                    'জেনারেটর ব্যাকআপ',
                    'নিরাপত্তা প্রহরী',
                    'ওয়াশরুম সুবিধা',
                ],
                'is_featured'    => false,
                'sort_order'     => 1,
            ],
            [
                'name'           => 'Full Day Package',
                'name_bn'        => 'ফুল ডে প্যাকেজ',
                'slug'           => 'full-day-12-hours',
                'duration_hours' => 12,
                'duration_label' => '12 Hours',
                'duration_label_bn' => '১২ ঘণ্টা',
                'price'          => 55000.00,
                'price_note'     => 'Starting from',
                'description'    => 'Ideal for weddings, holud ceremonies, receptions, and grand corporate events. Full day access with enhanced decoration support and premium facilities for up to 500 guests.',
                'description_bn' => 'বিবাহ, হলুদ অনুষ্ঠান, রিসেপশন এবং বড় কর্পোরেট ইভেন্টের জন্য আদর্শ। সর্বোচ্চ ৫০০ অতিথির জন্য সম্পূর্ণ দিনের প্রবেশাধিকার ও উন্নত সুবিধা।',
                'features'       => [
                    'Main Hall Access (up to 500 guests)',
                    'Premium Stage Setup with Lighting',
                    '4 Dressing Rooms + VIP Lounge',
                    'Catering Kitchen Access',
                    'Spacious Parking Area',
                    'Generator Backup (Full Capacity)',
                    'Dedicated Security Team',
                    'Sound System Support',
                    'Bridal Room Available',
                ],
                'features_bn'    => [
                    'মূল হল (সর্বোচ্চ ৫০০ অতিথি)',
                    'আলোকসজ্জাসহ প্রিমিয়াম মঞ্চ',
                    '৪টি ড্রেসিং রুম + ভিআইপি লাউঞ্জ',
                    'ক্যাটারিং রান্নাঘর সুবিধা',
                    'প্রশস্ত পার্কিং এলাকা',
                    'জেনারেটর ব্যাকআপ (পূর্ণ ক্যাপাসিটি)',
                    'ডেডিকেটেড নিরাপত্তা দল',
                    'সাউন্ড সিস্টেম সহায়তা',
                    'বিবাহের কক্ষ সুলভ',
                ],
                'is_featured'    => true,
                'sort_order'     => 2,
            ],
            [
                'name'           => 'Grand Event Package',
                'name_bn'        => 'গ্র্যান্ড ইভেন্ট প্যাকেজ',
                'slug'           => 'grand-event-24-hours',
                'duration_hours' => 24,
                'duration_label' => '24 Hours (Full Day & Night)',
                'duration_label_bn' => '২৪ ঘণ্টা (সম্পূর্ণ দিন ও রাত)',
                'price'          => 90000.00,
                'price_note'     => 'Starting from',
                'description'    => 'The ultimate venue package for multi-day weddings, grand receptions, corporate conferences, and national-level cultural festivals. Entire club premises at your disposal with unlimited setup time.',
                'description_bn' => 'বহু-দিনের বিবাহ, বড় রিসেপশন, কর্পোরেট কনফারেন্স এবং জাতীয় পর্যায়ের সাংস্কৃতিক উৎসবের জন্য চূড়ান্ত ভেন্যু প্যাকেজ। সীমাহীন সেটআপ সময় সহ সম্পূর্ণ ক্লাব প্রাঙ্গণ আপনার হাতে।',
                'features'       => [
                    'Entire Club Premises (800+ guests)',
                    'Grand Stage with Professional Lighting',
                    '6 Dressing Rooms + Bridal Suite',
                    'VIP Lounge & Waiting Areas',
                    'Full Catering Kitchen Access',
                    'Open Grounds for Outdoor Events',
                    'Generator Backup (Industrial Grade)',
                    'Full Security & Crowd Management',
                    'Professional Sound System',
                    'Projector & LED Screen Available',
                    'Unlimited Setup Time',
                    'Club Staff Assistance',
                ],
                'features_bn'    => [
                    'সম্পূর্ণ ক্লাব প্রাঙ্গণ (৮০০+ অতিথি)',
                    'পেশাদার আলোকসজ্জাসহ গ্র্যান্ড মঞ্চ',
                    '৬টি ড্রেসিং রুম + ব্রাইডাল স্যুট',
                    'ভিআইপি লাউঞ্জ ও প্রতীক্ষা কক্ষ',
                    'সম্পূর্ণ ক্যাটারিং রান্নাঘর সুবিধা',
                    'আউটডোর ইভেন্টের জন্য খোলা মাঠ',
                    'ইন্ডাস্ট্রিয়াল গ্রেড জেনারেটর',
                    'পূর্ণ নিরাপত্তা ও ভিড় ব্যবস্থাপনা',
                    'পেশাদার সাউন্ড সিস্টেম',
                    'প্রজেক্টর ও এলইডি স্ক্রিন',
                    'সীমাহীন সেটআপ সময়',
                    'ক্লাব স্টাফ সহায়তা',
                ],
                'is_featured'    => false,
                'sort_order'     => 3,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }

        \Schema::enableForeignKeyConstraints();
        $this->command->info('CPRC seed data inserted successfully. (' . count($members) . ' members, ' . count($packages) . ' packages)');
    }
}
