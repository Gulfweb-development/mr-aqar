<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Advertising;
use Faker\Generator as Faker;

$factory->define(Advertising::class, function (Faker $faker) {
    return [
        'type' => 'residential',
        'purpose' => $faker->randomElement(['rent', 'sell', 'exchange', 'required_for_rent']),
        'venue_type' => $faker->randomElement([8, 9, 10, 12]),
        'advertising_type' => $faker->optional($weight = 0.1, $default = 'normal')->randomElement(['premium']),
        'user_id' => $faker->randomElement([\App\User::where('id', '<', 10)->inRandomOrder()->first(), \App\User::where('type_usage', 'company')->first()]),
        'city_id' => 2,
        'area_id' => $faker->randomElement([70, 65, 23, 53, 153, 68, 74]),
        'description' => $faker->randomElement([
            'لوريم إيبسوم هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص،',
            'لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" البلاستيكية',
            'كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.',
            'لوريم إيبسوم هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" البلاستيكية تحوي
            مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج

            مايكر" والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.'
        ,null, $faker->text(100), $faker->text(200), $faker->text(400)]),
        'price' => $faker->randomElement([100000, 15300, 9850, 200, 100]),
        'phone_number' => $faker->numberBetween($min = 10000000, $max = 99999999),
        'main_image' => $faker->randomElement(['/resources/uploads/images/a1.jpg', '/resources/uploads/images/a2.jpg', '/resources/uploads/images/a3.jpg', '/resources/uploads/images/a4.jpg']),
        'other_image' => '{"other_image":["\/resources\/uploads\/images\/a2.jpg","\/resources\/uploads\/images\/a3.jpg", "\/resources\/uploads\/images\/a4.jpg"]}',
        'status' => 'accepted',
        'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now'),
        'expire_at' => $faker->randomElement(['2023-08-23 05:22:23', '2021-02-23 05:22:23']),
        'hash_number' => $faker->unique()->numberBetween($min = 1000000000, $max = 9999999999),
        'auto_extend' => rand(0,1),
    ];
});
