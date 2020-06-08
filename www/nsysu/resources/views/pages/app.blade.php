<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=0>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="author" content="高雄阿蓮天聖宮"/>
        <meta name="keywords" content="高雄天聖宮、高雄阿蓮天聖宮、高雄天聖宮-徐家莊、高雄阿蓮天聖宮-徐家莊、天聖宮、徐家莊、阿蓮媽"/>
        <meta name="copyright" content="高雄阿蓮天聖宮">
        <meta name="description" content="高雄阿蓮天聖宮即將一週年了，高雄阿蓮天聖宮-徐家莊在過去一年中慢慢的成長。阿蓮媽今年舉辦【懷舊童玩遊樂市集】想邀請各位朋友們帶著親朋好友及孩童前來高雄天聖宮-徐家莊。" />
        <meta name="URL" content="https://alianma.tw/">
        <meta property="og:site_name" content="台灣媽祖聯誼會"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="高雄阿蓮天聖宮"/>
        <meta property="og:image" content="https://alianma.tw/images/banner.jpg"/>
        <meta property="og:url" content="https://alianma.tw/"/>
        <meta property="og:description" content="高雄阿蓮天聖宮即將一週年了，高雄阿蓮天聖宮-徐家莊在過去一年中慢慢的成長。阿蓮媽今年舉辦【懷舊童玩遊樂市集】想邀請各位朋友們帶著親朋好友及孩童前來高雄天聖宮-徐家莊。"/>

        <meta itemprop="g-name" content="台灣媽祖聯誼會"/>
        <meta itemprop="g-image" content="https://alianma.tw/images/banner.jpg"/>
        <meta itemprop="g-description" content="高雄阿蓮天聖宮即將一週年了，高雄阿蓮天聖宮-徐家莊在過去一年中慢慢的成長。阿蓮媽今年舉辦【懷舊童玩遊樂市集】想邀請各位朋友們帶著親朋好友及孩童前來高雄天聖宮-徐家莊。"/>

        <meta property="twitter:image" content="https://alianma.tw/images/banner.jpg"/>
        <meta property="twitter:title" content="高雄阿蓮天聖宮"/>
        <meta property="twitter:description" content="高雄阿蓮天聖宮即將一週年了，高雄阿蓮天聖宮-徐家莊在過去一年中慢慢的成長。阿蓮媽今年舉辦【懷舊童玩遊樂市集】想邀請各位朋友們帶著親朋好友及孩童前來高雄天聖宮-徐家莊。"/>
        <meta name="google-site-verification" content="S6YQ0aivGYAU_ykMriZU8lDmGGTcV8LrPXIvMTe6-vk" /><!-- 測試google search console -->
        <title>高雄阿蓮天聖宮</title>
        <link href="{{ mix('css/pages/app.css') }}" media="all" rel="stylesheet" type="text/css" />
        @yield('css')
        <script type="application/ld+json" >
        {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "高雄阿蓮天聖宮",
      "image": "https://alianma.tw/images/banner.jpg",
      "description": "高雄阿蓮天聖宮即將一週年了，高雄阿蓮天聖宮-徐家莊在過去一年中慢慢的成長。阿蓮媽今年舉辦【懷舊童玩遊樂市集】想邀請各位朋友們帶著親朋好友及孩童前來高雄天聖宮-徐家莊。",
      "sku": "0446310786",
      "mpn": "925872",
      "brand": {
        "@type": "Thing",
        "name": "高雄阿蓮天聖宮"
      },
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "4",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "高雄阿蓮天聖宮"
        }
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.4",
        "reviewCount": "89"
      },
      "offers": {
        "@type": "Offer",
        "url": "https://alianma.tw/",
        "priceCurrency": "TWD",
        "price": "100",
        "priceValidUntil": "2020-12-31",
        "itemCondition": "https://schema.org/UsedCondition",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@type": "Organization",
          "name": "高雄阿蓮天聖宮"
        }
      }
    }
        </script>
        <script>
            var siteUrl = "{{ url('/') }}";
            var csrfToken = "{{ csrf_token() }}";
            var CKEDITOR_BASEPATH = '/js/ckeditor/';
        </script>
    </head>
    <body id="page-top">
        <div id="app"></div>
        <script src="{{ mix('js/pages/app.js') }}"></script>
    </body>
</html>

