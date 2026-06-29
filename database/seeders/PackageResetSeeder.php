<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageResetSeeder extends Seeder
{
    public function run(): void
    {
        Package::query()->delete();

        $packages = [
            [
                'name'           => 'General / Outsider Package',
                'name_bn'        => 'সাধারণ / বহিরাগত প্যাকেজ',
                'slug'           => 'general-outsider',
                'duration_hours' => 12,
                'duration_label' => 'Per Session',
                'duration_label_bn' => 'প্রতি সেশন',
                'price'          => 18000.00,
                'price_note'     => 'Starting from',
                'description'    => 'Ideal venue for weddings, grand receptions, corporate conferences, and large cultural festivals.',
                'description_bn' => 'বিবাহ অনুষ্ঠান, বড় রিসেপশন, কর্পোরেট কনফারেন্স এবং জাতীয় পর্যায়ের সাংস্কৃতিক উৎসবের জন্য সেরা ভেন্যু।',
                'features'       => [
                    'Main Hall Access (800+ Capacity)',
                    'Optional Field Rental (+৳10,000 BDT)',
                    'Night Shift Booking Surcharge (+৳2,000)',
                    '2 Decorated Dressing Rooms & Washrooms',
                    'Generator Backup & 24/7 Security',
                ],
                'features_bn'    => [
                    'মূল হল ব্যবহার (৮০০+ ধারণক্ষমতা)',
                    'মাঠ সহ বুকিংয়ের সুবিধা (+৳১০,০০০ BDT)',
                    'রাত শিফটে বুকিংয়ের ব্যবস্থা (+৳২,০০০ বিদ্যুৎ বিল)',
                    '২টি সজ্জিত ড্রেসিং রুম ও ওয়াশরুম',
                    'জেনারেটর ব্যাকআপ ও ২৪ ঘণ্টা নিরাপত্তা',
                ],
                'is_featured'    => true,
                'sort_order'     => 1,
                'is_active'      => true,
            ],
            [
                'name'           => 'CPA Staff Package',
                'name_bn'        => 'চবক কর্মকর্তা-কর্মচারী প্যাকেজ',
                'slug'           => 'cpa-staff',
                'duration_hours' => 12,
                'duration_label' => 'Per Session',
                'duration_label_bn' => 'প্রতি সেশন',
                'price'          => 5000.00,
                'price_note'     => 'Starting from',
                'description'    => 'Highly discounted rates for the officers and staff of the Chittagong Port Authority.',
                'description_bn' => 'চট্টগ্রাম বন্দর কর্তৃপক্ষের কর্মকর্তা ও কর্মচারীদের পারিবারিক অনুষ্ঠানের জন্য বিশেষ সুবিধাজনক বুকিং প্যাকেজ।',
                'features'       => [
                    'Full Main Hall Access',
                    'Optional Field Rental (+৳10,000 BDT)',
                    'Night Shift Booking Surcharge (+৳1,500)',
                    'Verification Required (CPA ID Card Upload)',
                    'All standard facilities & backup included',
                ],
                'features_bn'    => [
                    'মূল হলের সম্পূর্ণ সুবিধা ব্যবহার',
                    'মাঠ সহ বুকিংয়ের সুবিধা (+৳১০,০০০ BDT)',
                    'রাত শিফটে বুকিংয়ের ব্যবস্থা (+৳১,৫০০ বিদ্যুৎ বিল)',
                    'চবক পরিচয়পত্র (CPA ID Card) আপলোড বাধ্যতামূলক',
                    'সকল সুযোগ-সুবিধা ও ব্যাকআপ অন্তর্ভুক্ত',
                ],
                'is_featured'    => false,
                'sort_order'     => 2,
                'is_active'      => true,
            ],
            [
                'name'           => 'Republic Club Member Package',
                'name_bn'        => 'রিপাবলিক ক্লাব সদস্য প্যাকেজ',
                'slug'           => 'republic-club-member',
                'duration_hours' => 12,
                'duration_label' => 'Per Session',
                'duration_label_bn' => 'প্রতি সেশন',
                'price'          => 3000.00,
                'price_note'     => 'Starting from',
                'description'    => 'Exclusive privilege pricing and booking priority for members of the Chittagong Port Republic Club.',
                'description_bn' => 'চট্টগ্রাম বন্দর রিপাবলিক ক্লাবের সম্মানিত সদস্যদের জন্য প্রিভিলেজ বুকিং রেট এবং বিশেষ অগ্রাধিকার।',
                'features'       => [
                    'Priority Access to Hall & VIP Lounge',
                    'Optional Field Rental (+৳10,000 BDT)',
                    'Night Shift Booking Surcharge (+৳1,500)',
                    'Verification Required (Member ID Card/Paper)',
                    'Special Decoration & stage setup assistance',
                ],
                'features_bn'    => [
                    'হল ও ভিআইপি লাউঞ্জ ব্যবহারের অগ্রাধিকার',
                    'মাঠ সহ বুকিংয়ের সুবিধা (+৳১০,০০০ BDT)',
                    'রাত শিফটে বুকিংয়ের ব্যবস্থা (+৳১,৫০০ বিদ্যুৎ বিল)',
                    'সদস্য কার্ড বা যাচাইকরণ পত্র আপলোড বাধ্যতামূলক',
                    'বিশেষ ডেকোরেশন ও সাজসজ্জা সেশন',
                ],
                'is_featured'    => false,
                'sort_order'     => 3,
                'is_active'      => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }
}
