<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0"
     xml:base="http://googleme.com/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" >
{{--<feed xmlns="http://www.w3.org/2005/Atom">--}}
{{--    @foreach($meta as $key => $metaItem)--}}
{{--        @if($key === 'link')--}}
{{--            <{{ $key }} href="{{ url($metaItem) }}"></{{ $key }}>--}}
{{--        @elseif($key === 'title')--}}
{{--            <{{ $key }}><![CDATA[{{ $metaItem }}]]></{{ $key }}>--}}
{{--        @else--}}
{{--            <{{ $key }}>{{ $metaItem }}</{{ $key }}>--}}
{{--        @endif--}}
{{--    @endforeach--}}

    <channel>
        <title>googleme</title>
        <description> googleme Perimium Advertising</description>
        <link>http://googleme.com/</link>
        <atom:link rel="self" href="http://googleme.com/feed?lang={{request()->get('lang','en')}}" />
    @foreach($items as $item)
        <item>
            <title>{{ $item->title }}</title>
            <link>{{ url($item->link)}}</link>

            <description>
               {!! $item->summary !!}
            </description>
            <enclosure url="{{ url($item->link)}}" length="12216320" type="image/jpeg" />
            <guid isPermaLink="false">{{ url($item->link)}}</guid>
{{--            <author>--}}
{{--                <name> <![CDATA[{{ $item->author??'' }}]]></name>--}}
{{--            </author>--}}

            <pubDate>{{ $item->updated->toRssString() }}</pubDate>
            <source url="http://googleme.com/feed?lang={{request()->get('lang','en')}}">
                        googleme Advertising
            </source>
        </item>
    @endforeach
    </channel>
 </rss>

{{--</feed>--}}
