@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($staticRoute as $route)
        <url>
            <loc>{{$route['link']}}</loc>
            <lastmod>{{\Illuminate\Support\Carbon::now()->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
    @foreach($dynamicRoute as $ClassName)
            @foreach($ClassName as $route)
        <url>
            <loc>{{$route['link']}}</loc>
            <lastmod>{{$route['lastmod']->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
            @endforeach
    @endforeach
</urlset>
