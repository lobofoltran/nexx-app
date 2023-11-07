{{--  https://play-tailwind.tailgrids.com/ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nexx Soluctions</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite('resources/css/tailwind.css')
        <script>/*! WOW wow.js - v1.3.0 - 2016-10-04 * https://wowjs.uk * Copyright (c) 2016 Thomas Grainger; Licensed MIT */ !(function (a, b) {  if ("function" == typeof define && define.amd)    define(["module", "exports"], b);  else if ("undefined" != typeof exports) b(module, exports);  else {    var c = { exports: {} };    b(c, c.exports), (a.WOW = c.exports);  }})(this, function (a, b) {  "use strict";  function c(a, b) {    if (!(a instanceof b))      throw new TypeError("Cannot call a class as a function");  }  function d(a, b) {    return b.indexOf(a) >= 0;  }  function e(a, b) {    for (var c in b)      if (null == a[c]) {        var d = b[c];        a[c] = d;      }    return a;  }  function f(a) {    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(      a    );  }  function g(a) {    var b =        arguments.length <= 1 || void 0 === arguments[1] ? !1 : arguments[1],      c = arguments.length <= 2 || void 0 === arguments[2] ? !1 : arguments[2],      d =        arguments.length <= 3 || void 0 === arguments[3] ? null : arguments[3],      e = void 0;    return (      null != document.createEvent        ? ((e = document.createEvent("CustomEvent")),          e.initCustomEvent(a, b, c, d))        : null != document.createEventObject        ? ((e = document.createEventObject()), (e.eventType = a))        : (e.eventName = a),      e    );  }  function h(a, b) {    null != a.dispatchEvent      ? a.dispatchEvent(b)      : b in (null != a)      ? a[b]()      : "on" + b in (null != a) && a["on" + b]();  }  function i(a, b, c) {    null != a.addEventListener      ? a.addEventListener(b, c, !1)      : null != a.attachEvent      ? a.attachEvent("on" + b, c)      : (a[b] = c);  }  function j(a, b, c) {    null != a.removeEventListener      ? a.removeEventListener(b, c, !1)      : null != a.detachEvent      ? a.detachEvent("on" + b, c)      : delete a[b];  }  function k() {    return "innerHeight" in window      ? window.innerHeight      : document.documentElement.clientHeight;  }  Object.defineProperty(b, "__esModule", { value: !0 });  var l,    m,    n = (function () {      function a(a, b) {        for (var c = 0; c < b.length; c++) {          var d = b[c];          (d.enumerable = d.enumerable || !1),            (d.configurable = !0),            "value" in d && (d.writable = !0),            Object.defineProperty(a, d.key, d);        }      }      return function (b, c, d) {        return c && a(b.prototype, c), d && a(b, d), b;      };    })(),    o =      window.WeakMap ||      window.MozWeakMap ||      (function () {        function a() {          c(this, a), (this.keys = []), (this.values = []);        }        return (          n(a, [            {              key: "get",              value: function (a) {                for (var b = 0; b < this.keys.length; b++) {                  var c = this.keys[b];                  if (c === a) return this.values[b];                }              },            },            {              key: "set",              value: function (a, b) {                for (var c = 0; c < this.keys.length; c++) {                  var d = this.keys[c];                  if (d === a) return (this.values[c] = b), this;                }                return this.keys.push(a), this.values.push(b), this;              },            },          ]),          a        );      })(),    p =      window.MutationObserver ||      window.WebkitMutationObserver ||      window.MozMutationObserver ||      ((m = l =        (function () {          function a() {            c(this, a),              "undefined" != typeof console &&                null !== console &&                (console.warn(                  "MutationObserver is not supported by your browser."                ),                console.warn(                  "WOW.js cannot detect dom mutations, please call .sync() after loading new content."                ));          }          return n(a, [{ key: "observe", value: function () {} }]), a;        })()),      (l.notSupported = !0),      m),    q =      window.getComputedStyle ||      function (a) {        var b = /(\-([a-z]){1})/g;        return {          getPropertyValue: function (c) {            "float" === c && (c = "styleFloat"),              b.test(c) &&                c.replace(b, function (a, b) {                  return b.toUpperCase();                });            var d = a.currentStyle;            return (null != d ? d[c] : void 0) || null;          },        };      },    r = (function () {      function a() {        var b =          arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0];        c(this, a),          (this.defaults = {            boxClass: "wow",            animateClass: "animated",            offset: 0,            mobile: !0,            live: !0,            callback: null,            scrollContainer: null,            resetAnimation: !0,          }),          (this.animate = (function () {            return "requestAnimationFrame" in window              ? function (a) {                  return window.requestAnimationFrame(a);                }              : function (a) {                  return a();                };          })()),          (this.vendors = ["moz", "webkit"]),          (this.start = this.start.bind(this)),          (this.resetAnimation = this.resetAnimation.bind(this)),          (this.scrollHandler = this.scrollHandler.bind(this)),          (this.scrollCallback = this.scrollCallback.bind(this)),          (this.scrolled = !0),          (this.config = e(b, this.defaults)),          null != b.scrollContainer &&            (this.config.scrollContainer = document.querySelector(              b.scrollContainer            )),          (this.animationNameCache = new o()),          (this.wowEvent = g(this.config.boxClass));      }      return (        n(a, [          {            key: "init",            value: function () {              (this.element = window.document.documentElement),                d(document.readyState, ["interactive", "complete"])                  ? this.start()                  : i(document, "DOMContentLoaded", this.start),                (this.finished = []);            },          },          {            key: "start",            value: function () {              var a = this;              if (                ((this.stopped = !1),                (this.boxes = [].slice.call(                  this.element.querySelectorAll("." + this.config.boxClass)                )),                (this.all = this.boxes.slice(0)),                this.boxes.length)              )                if (this.disabled()) this.resetStyle();                else                  for (var b = 0; b < this.boxes.length; b++) {                    var c = this.boxes[b];                    this.applyStyle(c, !0);                  }              if (                (this.disabled() ||                  (i(                    this.config.scrollContainer || window,                    "scroll",                    this.scrollHandler                  ),                  i(window, "resize", this.scrollHandler),                  (this.interval = setInterval(this.scrollCallback, 50))),                this.config.live)              ) {                var d = new p(function (b) {                  for (var c = 0; c < b.length; c++)                    for (var d = b[c], e = 0; e < d.addedNodes.length; e++) {                      var f = d.addedNodes[e];                      a.doSync(f);                    }                });                d.observe(document.body, { childList: !0, subtree: !0 });              }            },          },          {            key: "stop",            value: function () {              (this.stopped = !0),                j(                  this.config.scrollContainer || window,                  "scroll",                  this.scrollHandler                ),                j(window, "resize", this.scrollHandler),                null != this.interval && clearInterval(this.interval);            },          },          {            key: "sync",            value: function () {              p.notSupported && this.doSync(this.element);            },          },          {            key: "doSync",            value: function (a) {              if (                (("undefined" != typeof a && null !== a) || (a = this.element),                1 === a.nodeType)              ) {                a = a.parentNode || a;                for (                  var b = a.querySelectorAll("." + this.config.boxClass), c = 0;                  c < b.length;                  c++                ) {                  var e = b[c];                  d(e, this.all) ||                    (this.boxes.push(e),                    this.all.push(e),                    this.stopped || this.disabled()                      ? this.resetStyle()                      : this.applyStyle(e, !0),                    (this.scrolled = !0));                }              }            },          },          {            key: "show",            value: function (a) {              return (                this.applyStyle(a),                (a.className = a.className + " " + this.config.animateClass),                null != this.config.callback && this.config.callback(a),                h(a, this.wowEvent),                this.config.resetAnimation &&                  (i(a, "animationend", this.resetAnimation),                  i(a, "oanimationend", this.resetAnimation),                  i(a, "webkitAnimationEnd", this.resetAnimation),                  i(a, "MSAnimationEnd", this.resetAnimation)),                a              );            },          },          {            key: "applyStyle",            value: function (a, b) {              var c = this,                d = a.getAttribute("data-wow-duration"),                e = a.getAttribute("data-wow-delay"),                f = a.getAttribute("data-wow-iteration");              return this.animate(function () {                return c.customStyle(a, b, d, e, f);              });            },          },          {            key: "resetStyle",            value: function () {              for (var a = 0; a < this.boxes.length; a++) {                var b = this.boxes[a];                b.style.visibility = "visible";              }            },          },          {            key: "resetAnimation",            value: function (a) {              if (a.type.toLowerCase().indexOf("animationend") >= 0) {                var b = a.target || a.srcElement;                b.className = b.className                  .replace(this.config.animateClass, "")                  .trim();              }            },          },          {            key: "customStyle",            value: function (a, b, c, d, e) {              return (                b && this.cacheAnimationName(a),                (a.style.visibility = b ? "hidden" : "visible"),                c && this.vendorSet(a.style, { animationDuration: c }),                d && this.vendorSet(a.style, { animationDelay: d }),                e && this.vendorSet(a.style, { animationIterationCount: e }),                this.vendorSet(a.style, {                  animationName: b ? "none" : this.cachedAnimationName(a),                }),                a              );            },          },          {            key: "vendorSet",            value: function (a, b) {              for (var c in b)                if (b.hasOwnProperty(c)) {                  var d = b[c];                  a["" + c] = d;                  for (var e = 0; e < this.vendors.length; e++) {                    var f = this.vendors[e];                    a["" + f + c.charAt(0).toUpperCase() + c.substr(1)] = d;                  }                }            },          },          {            key: "vendorCSS",            value: function (a, b) {              for (                var c = q(a), d = c.getPropertyCSSValue(b), e = 0;                e < this.vendors.length;                e++              ) {                var f = this.vendors[e];                d = d || c.getPropertyCSSValue("-" + f + "-" + b);              }              return d;            },          },          {            key: "animationName",            value: function (a) {              var b = void 0;              try {                b = this.vendorCSS(a, "animation-name").cssText;              } catch (c) {                b = q(a).getPropertyValue("animation-name");              }              return "none" === b ? "" : b;            },          },          {            key: "cacheAnimationName",            value: function (a) {              return this.animationNameCache.set(a, this.animationName(a));            },          },          {            key: "cachedAnimationName",            value: function (a) {              return this.animationNameCache.get(a);            },          },          {            key: "scrollHandler",            value: function () {              this.scrolled = !0;            },          },          {            key: "scrollCallback",            value: function () {              if (this.scrolled) {                this.scrolled = !1;                for (var a = [], b = 0; b < this.boxes.length; b++) {                  var c = this.boxes[b];                  if (c) {                    if (this.isVisible(c)) {                      this.show(c);                      continue;                    }                    a.push(c);                  }                }                (this.boxes = a),                  this.boxes.length || this.config.live || this.stop();              }            },          },          {            key: "offsetTop",            value: function (a) {              for (; void 0 === a.offsetTop; ) a = a.parentNode;              for (var b = a.offsetTop; a.offsetParent; )                (a = a.offsetParent), (b += a.offsetTop);              return b;            },          },          {            key: "isVisible",            value: function (a) {              var b = a.getAttribute("data-wow-offset") || this.config.offset,                c =                  (this.config.scrollContainer &&                    this.config.scrollContainer.scrollTop) ||                  window.pageYOffset,                d = c + Math.min(this.element.clientHeight, k()) - b,                e = this.offsetTop(a),                f = e + a.clientHeight;              return d >= e && f >= c;            },          },          {            key: "disabled",            value: function () {              return !this.config.mobile && f(navigator.userAgent);            },          },        ]),        a      );    })();  (b["default"] = r), (a.exports = b["default"]);});</script>
      </head>
      <body>
        <!-- ====== Navbar Section Start -->
        <div
          class="ud-header absolute top-0 left-0 z-40 flex w-full items-center bg-transparent"
        >
          <div class="container">
            <div class="relative -mx-4 flex items-center justify-between">
              <div class="w-60 max-w-full px-4">
                <a href="/" class="navbar-logo block w-full py-5">
                  <img
                    src="{{ asset('/images/logo-branca.png') }}"
                    alt="logo"
                    class="header-logo w-8"
                  />
                </a>
              </div>
              <div class="flex w-full items-center justify-between px-4">
                <div>
                  <button
                    id="navbarToggler"
                    class="absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 py-[6px] ring-primary focus:ring-2 lg:hidden"
                  >
                    <span
                      class="relative my-[6px] block h-[2px] w-[30px] bg-white"
                    ></span>
                    <span
                      class="relative my-[6px] block h-[2px] w-[30px] bg-white"
                    ></span>
                    <span
                      class="relative my-[6px] block h-[2px] w-[30px] bg-white"
                    ></span>
                  </button>
                  <nav
                    id="navbarCollapse"
                    class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white py-5 shadow-lg lg:static lg:block lg:w-full lg:max-w-full lg:bg-transparent lg:py-0 lg:px-4 lg:shadow-none xl:px-6"
                  >
                    {{-- <ul class="blcok lg:flex"> --}}
                      {{-- <li class="group relative">
                        <a
                          href="#home"
                          class="ud-menu-scroll mx-8 flex py-2 text-base text-dark group-hover:text-primary lg:mr-0 lg:inline-flex lg:py-6 lg:px-0 lg:text-white lg:group-hover:text-white lg:group-hover:opacity-70"
                        >
                          Início
                        </a>
                      </li> --}}
                  </nav>
                </div>
                <div class="hidden justify-end pr-16 sm:flex lg:pr-0">
                  <a
                    href="{{ route('login') }}"
                    class="loginBtn py-3 px-7 text-base font-medium text-white hover:opacity-70"
                  >
                    Entrar
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ====== Navbar Section End -->
    
        <!-- ====== Hero Section Start -->
        <div
          id="home"
          class="relative overflow-hidden bg-primary pt-[120px] md:pt-[130px] lg:pt-[160px]"
        >
          <div class="container">
            <div class="-mx-4 flex flex-wrap items-center">
              <div class="w-full px-4">
                <div
                  class="hero-content wow fadeInUp mx-auto max-w-[780px] text-center"
                  data-wow-delay=".2s"
                >
                  <h1
                    class="mb-8 text-3xl font-bold leading-snug text-white sm:text-4xl sm:leading-snug md:text-[45px] md:leading-snug"
                  >
                  Bem vindo ao futuro da Gestão de Comandas e Mesas
                  </h1>
                  <p
                    class="mx-auto mb-10 max-w-[600px] text-base text-[#e4e4e4] sm:text-lg sm:leading-relaxed md:text-xl md:leading-relaxed"
                  >
                  Um sistema avançado e automatizado para agilizar o atendimento e aumentar a eficiência do seu negócio
                  </p>
                  <ul class="mb-10 flex flex-wrap items-center justify-center">
                    <li>
                      <a
                        href="/"
                        class="inline-flex items-center justify-center rounded-lg bg-white py-4 px-6 text-center text-base font-medium text-dark transition duration-300 ease-in-out hover:text-primary hover:shadow-lg sm:px-10"
                      >
                        Entre em contato
                      </a>
                    </li>
                  </ul>
                  {{-- <div class="wow fadeInUp text-center" data-wow-delay=".3s">
                    <img
                      src="{{ asset('images/laravel.png') }}"
                      alt="image"
                      class="mx-auto h-16 opacity-50 transition duration-300 ease-in-out hover:opacity-100"
                    />
                  </div> --}}
                </div>
              </div>
    
              <div class="w-full px-4">
                <div
                  class="wow fadeInUp relative z-10 mx-auto max-w-[845px]"
                  data-wow-delay=".25s"
                >
                  <div class="mt-16">
                    <img
                      src="{{ asset('images/system.png') }}"
                      alt="hero"
                      class="mx-auto max-w-full rounded-t-xl rounded-tr-xl"
                    />
                  </div>
                  <div class="absolute bottom-0 -left-9 z-[-1]">
                    <svg
                      width="134"
                      height="106"
                      viewBox="0 0 134 106"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <circle
                        cx="1.66667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 1.66667 104)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 16.3333 104)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 31 104)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 45.6667 104)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 60.3333 104)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 88.6667 104)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 117.667 104)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 74.6667 104)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 103 104)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 132 104)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 1.66667 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 16.3333 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 31 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 45.6667 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 60.3333 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 88.6667 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 117.667 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 74.6667 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 103 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 132 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="74.6673"
                        r="1.66667"
                        transform="rotate(-90 1.66667 74.6673)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 1.66667 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 16.3333 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 16.3333 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 31 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 31 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 45.6667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 45.6667 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 60.3333 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 60.3333 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 88.6667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 88.6667 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 117.667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 117.667 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 74.6667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 74.6667 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 103 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 103 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 132 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 132 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 1.66667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 1.66667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 16.3333 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 16.3333 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 31 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 31 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 45.6667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 45.6667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 60.3333 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 60.3333 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 88.6667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 88.6667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 117.667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 117.667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 74.6667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 74.6667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 103 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 103 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 132 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 132 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 1.66667 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 1.66667 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 16.3333 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 16.3333 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 31 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 31 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 45.6667 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 45.6667 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 60.3333 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 60.3333 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 88.6667 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 88.6667 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 117.667 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 117.667 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 74.6667 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 74.6667 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 103 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 103 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 132 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 132 1.66707)"
                        fill="white"
                      />
                    </svg>
                  </div>
                  <div class="absolute -top-6 -right-6 z-[-1]">
                    <svg
                      width="134"
                      height="106"
                      viewBox="0 0 134 106"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <circle
                        cx="1.66667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 1.66667 104)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 16.3333 104)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 31 104)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 45.6667 104)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 60.3333 104)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 88.6667 104)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 117.667 104)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 74.6667 104)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 103 104)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="104"
                        r="1.66667"
                        transform="rotate(-90 132 104)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 1.66667 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 16.3333 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 31 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="89.3333"
                        r="1.66667"
                        transform="rotate(-90 45.6667 89.3333)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 60.3333 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 88.6667 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 117.667 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 74.6667 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 103 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="89.3338"
                        r="1.66667"
                        transform="rotate(-90 132 89.3338)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="74.6673"
                        r="1.66667"
                        transform="rotate(-90 1.66667 74.6673)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 1.66667 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 16.3333 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 16.3333 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 31 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 31 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 45.6667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="31.0003"
                        r="1.66667"
                        transform="rotate(-90 45.6667 31.0003)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 60.3333 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 60.3333 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 88.6667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 88.6667 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 117.667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 117.667 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 74.6667 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 74.6667 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 103 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 103 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="74.6668"
                        r="1.66667"
                        transform="rotate(-90 132 74.6668)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="31.0001"
                        r="1.66667"
                        transform="rotate(-90 132 31.0001)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 1.66667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 1.66667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 16.3333 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 16.3333 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 31 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 31 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 45.6667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 45.6667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 60.3333 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 60.3333 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 88.6667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 88.6667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 117.667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 117.667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 74.6667 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 74.6667 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 103 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 103 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="60.0003"
                        r="1.66667"
                        transform="rotate(-90 132 60.0003)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="16.3336"
                        r="1.66667"
                        transform="rotate(-90 132 16.3336)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 1.66667 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="1.66667"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 1.66667 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 16.3333 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="16.3333"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 16.3333 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 31 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="31"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 31 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="45.3336"
                        r="1.66667"
                        transform="rotate(-90 45.6667 45.3336)"
                        fill="white"
                      />
                      <circle
                        cx="45.6667"
                        cy="1.66683"
                        r="1.66667"
                        transform="rotate(-90 45.6667 1.66683)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 60.3333 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="60.3333"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 60.3333 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 88.6667 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="88.6667"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 88.6667 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 117.667 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="117.667"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 117.667 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 74.6667 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="74.6667"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 74.6667 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 103 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="103"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 103 1.66707)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="45.3338"
                        r="1.66667"
                        transform="rotate(-90 132 45.3338)"
                        fill="white"
                      />
                      <circle
                        cx="132"
                        cy="1.66707"
                        r="1.66667"
                        transform="rotate(-90 132 1.66707)"
                        fill="white"
                      />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ====== Hero Section End -->
    
        <!-- ====== Footer Section Start -->
        <footer
          class="wow fadeInUp relative z-10 bg-black"
          data-wow-delay=".15s"
        >
    
          <div class="border-opacity-40">
            <div class="container">
              <div class="-mx-4 flex flex-wrap">
                <div class="w-full px-4">
                  <div class="my-1 flex justify-center">
                    <p class="text-base text-[#f3f4fe]">
                      Desenvolvido por
                      <a
                        href="https://nexx.lobofoltran.com"
                        rel="nofollow noopner"
                        target="_blank"
                        class="text-white hover:underline"
                      >
                        Nexx Soluctions
                      </a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
    
          <div>
        </footer>
        <!-- ====== Footer Section End -->
    
        <!-- ====== Back To Top Start -->
        <a
          href="javascript:void(0)"
          class="back-to-top fixed bottom-8 right-8 left-auto z-[999] hidden h-10 w-10 items-center justify-center rounded-md bg-primary text-white shadow-md transition duration-300 ease-in-out hover:bg-dark"
        >
          <span
            class="mt-[6px] h-3 w-3 rotate-45 border-t border-l border-white"
          ></span>
        </a>
        <!-- ====== Back To Top End -->
    
        {{-- <script src="assets/js/main.js"></script> --}}
        <script>
          // ==== for menu scroll
          const pageLink = document.querySelectorAll(".ud-menu-scroll");
    
          pageLink.forEach((elem) => {
            elem.addEventListener("click", (e) => {
              e.preventDefault();
              document.querySelector(elem.getAttribute("href")).scrollIntoView({
                behavior: "smooth",
                offsetTop: 1 - 60,
              });
            });
          });
    
          // section menu active
          function onScroll(event) {
            const sections = document.querySelectorAll(".ud-menu-scroll");
            const scrollPos =
              window.pageYOffset ||
              document.documentElement.scrollTop ||
              document.body.scrollTop;
    
            for (let i = 0; i < sections.length; i++) {
              const currLink = sections[i];
              const val = currLink.getAttribute("href");
              const refElement = document.querySelector(val);
              const scrollTopMinus = scrollPos + 73;
              if (
                refElement.offsetTop <= scrollTopMinus &&
                refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
              ) {
                document
                  .querySelector(".ud-menu-scroll")
                  .classList.remove("active");
                currLink.classList.add("active");
              } else {
                currLink.classList.remove("active");
              }
            }
          }
    
          window.document.addEventListener("scroll", onScroll);
        </script>
      <script>
        new WOW().init();
      </script>
  </body>
</html>