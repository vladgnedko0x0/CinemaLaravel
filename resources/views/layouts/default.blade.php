<!DOCTYPE html>
<html lang="en">

<head>
<link href="/css/footer.css" rel="stylesheet">
  <link href="/css/animate.css" rel="stylesheet">
  <link href="/css/errors.css" rel="stylesheet">
  <script src="/js/wow.min.js"></script>
  <script src="/js/restoreErrorsOverlay.js" async defer></script>
  <!-- <script src="/js/footerAnimation.js" async defer></script> -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
  >
  @yield('head')
 
</head>

<body>
  <div class='root'>
 
    @yield('content')
<div class="footer animated">
  <div class="logo"><img src="/logo/logoNotBG.png"></div>
  <div class="socials">
    <div class="social"><a href="https://twitter.com/GnedVlad"><img width="60px"  src="/socials/twt.gif"></a></div><p>/</p>
    <div class="social"><a href="https://www.instagram.com/"><img width="60px" src="/socials/inst.gif"></a></div><p>/</p>
    <div class="social"><a href="https://www.tiktok.com/"><img width="60px"  src="/socials/tkt.gif"></a></div><p>/</p>
    <div class="social"><a href="https://t.me/exeption_error"><img width="60px"  src="/socials/tg.gif"></a></div>
  </div>
</div>
  </div>
  </script>
</body>

</html>
<script>
 
new WOW().init();
</script> 