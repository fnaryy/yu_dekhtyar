<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ЮРИЙ ДЕХТЯР — Influence-агентство</title>
  <meta name="description" content="Influence-агентство Юрия Дехтяра. Подбираем блогеров, продумываем механику и доводим до измеримого результата.">
  <link rel="icon" type="image/jpeg" href="{{ asset('site/images/case-thumb.jpg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@300;400;500;600;700;800&family=Oswald:wght@600;700&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('site/styles.css') }}?v={{ filemtime(public_path('site/styles.css')) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

  {{-- ============ HEADER ============ --}}
  <header class="header">
    <div class="header__inner">
      <a href="#top" class="header__brand">
        <span class="header__brand-name">Ю.ДЕХТЯР</span>
        <span class="header__brand-sub">[INFLUENCE / 2020+]</span>
      </a>
      <nav class="header__nav" aria-label="Основная навигация">
        <a href="#about">[О НАС]</a>
        <a href="#services">[УСЛУГИ]</a>
        <a href="#cases">[КЕЙСЫ]</a>
        <a href="#contact">[КОНТАКТЫ]</a>
      </nav>
      <a href="#contact" class="header__cta">НАЧАТЬ ПРОЕКТ <span aria-hidden="true">→</span></a>
      <button class="header__burger" aria-label="Меню" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <main id="top">

    {{-- ============ 01 / HERO ============ --}}
    <section class="hero" id="about">
      <div class="hero__top">
        <span class="bracket">[ПОРТФОЛИО ’26]</span>
        <span class="bracket">[ПРОКРУТИ ВНИЗ ↓]</span>
      </div>

      <h1 class="hero__title">
        {{ $hero->title_top }}<br>
        {{ $hero->title_middle }} <span class="hero__arrow" aria-hidden="true">→</span><br>
        {{ $hero->title_bottom_prefix }} <span class="hero__title-accent">{{ $hero->title_accent }}</span>
      </h1>

      <div class="hero__bottom">
        <p class="hero__desc">{!! nl2br(e($hero->description)) !!}</p>
        <a href="#contact" class="btn btn--primary">НАЧАТЬ ПРОЕКТ <span aria-hidden="true">→</span></a>
      </div>

      <div class="hero__stats" role="list">
        @foreach($hero->stats ?? [] as $stat)
          <div class="stat" role="listitem">
            <span class="stat__num">{{ $stat['num'] ?? '' }}</span>
            <span class="stat__label">{{ $stat['label'] ?? '' }}</span>
          </div>
        @endforeach
      </div>
    </section>

    {{-- ============ 02 / SERVICES (FLIP CARDS) ============ --}}
    <section class="services" id="services">
      <header class="section-header">
        <span class="bracket">[02 / ЧТО МЫ ДЕЛАЕМ]</span>
        <h2 class="section-title">УСЛУГИ <span class="section-title__muted">— кликни карточку</span></h2>
      </header>

      <div class="flip-grid">
        @foreach($flipCards as $card)
          <article class="flip-card" tabindex="0" role="button" aria-pressed="false">
            <div class="flip-card__inner">
              <div class="flip-card__face flip-card__front">
                <span class="flip-card__num">{{ $card->num }}</span>
                <h3 class="flip-card__title">{{ $card->title }}</h3>
                <span class="flip-card__hint">КЛИКНИ →</span>
              </div>
              <div class="flip-card__face flip-card__back">
                <p>{{ $card->description }}</p>
                <span class="flip-card__hint">← НАЗАД</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>

    {{-- ============ 03 / ACTIVE CASE ============ --}}
    @php($firstCase = $casesForJs->first())
    <section class="case" id="case-detail" aria-live="polite">
      <header class="section-header">
        <span class="bracket">[03 / АКТИВНЫЙ КЕЙС]</span>
        <h2 class="section-title">КЕЙС
          <span class="section-title__muted" id="case-counter">/ 01 / {{ str_pad($casesForJs->count(), 2, '0', STR_PAD_LEFT) }}</span>
        </h2>
      </header>

      <div class="case__layout">
        <div class="case__main">
          <div class="case__head">
            <span class="case__brand" id="case-brand">{{ $firstCase['brand'] ?? '' }}</span>
            <span class="case__category" id="case-category">/ {{ $firstCase['category'] ?? '' }}</span>
          </div>

          <div class="case__row">
            <span class="bracket case__row-label">[ С КАКИМ ВОПРОСОМ ПРИШЛИ ]</span>
            <p class="case__row-text" id="case-problem">{{ $firstCase['problem'] ?? '' }}</p>
          </div>

          <div class="case__row case__row--accordion">
            <button class="case__accordion-toggle" aria-expanded="false" type="button">
              <span class="bracket case__row-label">[ ЧТО МЫ СДЕЛАЛИ ]</span>
              <span class="case__accordion-icon" aria-hidden="true">+</span>
            </button>
            <div class="case__accordion-content">
              <p class="case__row-text" id="case-solution">{{ $firstCase['solution'] ?? '' }}</p>
              <div class="case__accordion-extra" id="case-solution-full">
                @foreach(($firstCase['solutionFull'] ?? []) as $p)
                  <p>{{ $p }}</p>
                @endforeach
              </div>
            </div>
          </div>

          <div class="case__grid">
            <div class="case__cell">
              <span class="bracket case__row-label">[ ПЛОЩАДКИ ]</span>
              <ul class="case__list" id="case-platforms">
                @foreach(($firstCase['platforms'] ?? []) as $p)
                  <li>{{ $p }}</li>
                @endforeach
              </ul>
            </div>
            <div class="case__cell">
              <span class="bracket case__row-label">[ ЦЕЛЕВАЯ АУДИТОРИЯ ]</span>
              <ul class="case__list" id="case-audience">
                @foreach(($firstCase['audience'] ?? []) as $a)
                  <li>{{ $a }}</li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="case__row">
            <span class="bracket case__row-label">[ ЗАДЕЙСТВОВАНО АВТОРОВ ]</span>
            <div class="case__authors" id="case-authors">
              @php($a = $firstCase['authors'] ?? ['total' => 0, 'micro' => 0, 'mid' => 0, 'top' => 0])
              <span class="case__authors-total">{{ $a['total'] }} АВТОРОВ</span>
              @php($tiers = array_filter([
                $a['micro'] ? "{$a['micro']} микро" : null,
                $a['mid']   ? "{$a['mid']} миддл"   : null,
                $a['top']   ? "{$a['top']} топ"     : null,
              ]))
              @foreach($tiers as $i => $t)
                <span class="case__authors-divider">{{ $i === 0 ? '/' : '·' }}</span>
                <span>{{ $t }}</span>
              @endforeach
            </div>
          </div>
        </div>

        <aside class="case__side">
          <div class="case__client">
            <div class="case__client-photo" id="case-client-photo" aria-hidden="true">
              @if(!empty($firstCase['client']['photo']))
                <img src="{{ $firstCase['client']['photo'] }}" alt="{{ $firstCase['client']['name'] ?? '' }}">
              @else
                {{ $firstCase['client']['initials'] ?? '' }}
              @endif
            </div>
            <div class="case__client-info">
              <span class="case__client-name" id="case-client-name">{{ $firstCase['client']['name'] ?? '' }}</span>
              <span class="case__client-role" id="case-client-role">{{ $firstCase['client']['role'] ?? '' }}</span>
            </div>
          </div>

          <blockquote class="case__quote" id="case-testimonial">{{ $firstCase['client']['testimonial'] ?? '' }}</blockquote>

          <a href="{{ $firstCase['video']['url'] ?? '#' }}" class="case__video" id="case-video-link" target="_blank" rel="noopener">
            <div class="case__video-thumb" id="case-video-thumb"
                 @if(!empty($firstCase['video']['thumbnail'])) style="background-image: url('{{ $firstCase['video']['thumbnail'] }}');" @endif>
              <span class="case__video-brand" id="case-video-brand">{{ $firstCase['video']['brand'] ?? '' }}</span>
              <span class="case__video-author" id="case-video-author">{{ $firstCase['video']['author'] ?? '' }}</span>
              <span class="case__video-play" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
              </span>
            </div>
            <div class="case__video-meta">
              <span><span aria-hidden="true">👁</span> <span id="case-video-views">{{ $firstCase['video']['views'] ?? '' }}</span></span>
              <span class="case__video-divider">·</span>
              <span id="case-video-date">{{ $firstCase['video']['date'] ?? '' }}</span>
              <span class="case__video-cta">смотреть →</span>
            </div>
          </a>
        </aside>
      </div>
    </section>

    {{-- ============ 04 / ALL CASES GRID ============ --}}
    <section class="cases" id="cases">
      <header class="section-header">
        <span class="bracket">[04 / ВСЕ КЕЙСЫ]</span>
        <h2 class="section-title">ПОРТФОЛИО <span class="section-title__muted">— выбери для подробностей</span></h2>
      </header>

      <div class="cases__grid" id="cases-grid">
        @foreach($casesForJs as $i => $c)
          <article class="case-card{{ $i === 0 ? ' is-active' : '' }}" data-case-id="{{ $c['id'] }}" tabindex="0" role="button" aria-label="Открыть кейс {{ $c['brand'] }}">
            <div class="case-card__inner">
              <span class="case-card__num">[{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($casesForJs->count(), 2, '0', STR_PAD_LEFT) }}]</span>
              <div>
                <h3 class="case-card__brand">{{ $c['brand'] }}</h3>
                <div class="case-card__meta">
                  <span>{{ explode(' · ', $c['category'])[0] }}</span>
                  <span class="case-card__arrow">→</span>
                </div>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>

    {{-- ============ 05 / CONTACT ============ --}}
    <section class="contact" id="contact">
      <div class="contact__layout">
        <div class="contact__intro">
          <span class="bracket">[05 / СВЯЗАТЬСЯ]</span>
          <h2 class="contact__title">ЕСТЬ ИДЕЯ?<br>ОБСУДИМ.</h2>
          <p class="contact__lead">
            Оставьте контакты&nbsp;— ответим в течение рабочего дня. Расскажем, подходит ли нам ваш продукт, и предложим формат.
          </p>
          <div class="contact__direct">
            <span class="bracket">[ИЛИ НАПРЯМУЮ]</span>
            <a href="https://t.me/yu_dekhtyar" target="_blank" rel="noopener">→ Telegram</a>
            <a href="mailto:hello@dekhtyar.ru">→ hello@dekhtyar.ru</a>
          </div>
        </div>

        <form class="contact__form" id="contact-form" method="POST" action="{{ url('/lead') }}" novalidate>
          @csrf
          <div class="field">
            <label for="f-name">ИМЯ <span aria-hidden="true">*</span></label>
            <input id="f-name" name="name" type="text" required placeholder="Как к вам обращаться">
          </div>
          <div class="field">
            <label for="f-company">КОМПАНИЯ <span aria-hidden="true">*</span></label>
            <input id="f-company" name="company" type="text" required placeholder="Название бренда">
          </div>
          <div class="field">
            <label for="f-contact">E-MAIL ИЛИ TELEGRAM <span aria-hidden="true">*</span></label>
            <input id="f-contact" name="contact" type="text" required placeholder="hello@brand.com  /  @username">
          </div>
          <div class="field">
            <label for="f-phone">ТЕЛЕФОН</label>
            <input id="f-phone" name="phone" type="tel" placeholder="+7 (___) ___-__-__">
          </div>
          <div class="field field--full">
            <label for="f-message">КРАТКО О ПРОЕКТЕ</label>
            <textarea id="f-message" name="message" rows="3" placeholder="Продукт, бюджет, сроки, цели"></textarea>
          </div>

          <div class="contact__submit">
            <p class="contact__note">
              Нажимая кнопку, вы соглашаетесь с обработкой данных.<br>
              Заявка приходит в&nbsp;CRM и Telegram-бот&nbsp;— ответим до конца дня.
            </p>
            <button class="btn btn--primary btn--large" type="submit">
              ОТПРАВИТЬ <span aria-hidden="true">→</span>
            </button>
          </div>

          <div class="form-result" id="form-result" hidden>
            <span class="bracket">[✓ ЗАЯВКА ОТПРАВЛЕНА]</span>
            <p>Спасибо! Мы получили заявку и свяжемся в ближайшее время.</p>
          </div>
        </form>
      </div>
    </section>
  </main>

  {{-- ============ FOOTER ============ --}}
  <footer class="footer">
    <div class="footer__top">
      <span class="footer__brand">ЮРИЙ ДЕХТЯР</span>
      <span class="bracket">[INFLUENCE / 2020+]</span>
    </div>
    <div class="footer__grid">
      <div class="footer__col">
        <span class="bracket">[НАВИГАЦИЯ]</span>
        <a href="#about">О нас</a>
        <a href="#services">Услуги</a>
        <a href="#cases">Кейсы</a>
        <a href="#contact">Контакты</a>
      </div>
      <div class="footer__col">
        <span class="bracket">[КОНТАКТЫ]</span>
        <a href="https://t.me/yu_dekhtyar" target="_blank" rel="noopener">Telegram</a>
        <a href="mailto:hello@dekhtyar.ru">hello@dekhtyar.ru</a>
        <a href="tel:+79991234567">+7 (999) 123-45-67</a>
      </div>
      <div class="footer__col">
        <span class="bracket">[СОЦСЕТИ]</span>
        <a href="#">Instagram</a>
        <a href="#">YouTube</a>
        <a href="#">VK</a>
      </div>
    </div>
    <div class="footer__bottom">
      <span>© 2020–{{ date('Y') }} · ЮРИЙ ДЕХТЯР</span>
      <span>Москва · работаем по всему миру</span>
    </div>
  </footer>

  <script>window.SITE_CASES = @json($casesForJs);</script>
  <script src="{{ asset('site/script.js') }}?v={{ filemtime(public_path('site/script.js')) }}"></script>
</body>
</html>
