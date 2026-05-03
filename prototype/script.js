/* ============================================================
   ЮРИЙ ДЕХТЯР — interactions
   ============================================================ */

/* ---------- DATA: cases ---------- */
const cases = [
  {
    id: 'nordfit',
    brand: 'NORDFIT',
    category: 'Спортивная обувь · 2025',
    problem: 'Бренд кроссовок выходил на массовый рынок РФ. Узнаваемость — низкая, конкуренция — высокая, бюджет на ТВ — нет. Нужно было быстро занять место в голове аудитории 18–34.',
    solution: 'Запустили серию из 12 интеграций у бегового и lifestyle-комьюнити. Сделали ставку на микро- и mid-tier, а не на топов.',
    solutionFull: [
      'Разбили кампанию на три волны: сначала «бытовые» интеграции у микро-блогеров для нативного знакомства, затем хедлайнер-ролик у mid-инфлюенсера-марафонца с разбором технологий, в финале — UGC-челлендж с промокодом на 7 дней.',
      'Каждому автору давали индивидуальный UTM и промокод. Креатив — только в виде брифа: автор писал текст сам, мы корректировали факты и тон. Это дало эффект «честной» рекомендации.',
      'Параллельно подключили ремаркетинг по тёплой аудитории, которая взаимодействовала с роликами — добили её таргетом в VK Ads и Telegram Ads.'
    ],
    platforms: ['YouTube', 'Telegram', 'Instagram', 'VK Видео'],
    audience: ['M / F · 18–34', 'РФ, СНГ', 'Спорт, ЗОЖ, бег'],
    authors: { total: 12, micro: 8, mid: 3, top: 1 },
    client: {
      name: 'Алексей Морозов',
      role: 'CMO · NORDFIT',
      initials: 'АМ',
      testimonial: '«За три месяца кампании выросли с 2 000 заказов в месяц до 11 000. Юра не просто закупил блогеров — он построил воронку, которую теперь повторяем сами.»'
    },
    video: {
      brand: 'NORDFIT',
      author: '@runner_pro',
      url: 'https://www.youtube.com/watch?v=RvBwypGUkPo',
      thumbnail: 'https://img.youtube.com/vi/RvBwypGUkPo/maxresdefault.jpg',
      views: '1.2M просмотров',
      date: '12.04.2026'
    }
  },
  {
    id: 'pixelhaus',
    brand: 'PIXELHAUS',
    category: 'Smart-устройства · 2025',
    problem: 'Запуск умной колонки на конкурентном рынке. Главный риск — массовый обзор без эмоций, который потеряется в ленте.',
    solution: 'Сделали ставку на tech-обзорщиков и фуд-блогеров одновременно — показали продукт в двух разных контекстах.',
    solutionFull: [
      'Tech-сегмент дал глубину: разборы железа, сравнение с конкурентами, замеры. Это закрыло rational-потребность аудитории.',
      'Фуд-блогеры показали колонку как часть кухонного ритуала — эмоциональный слой. Совмещение двух мирах дало неожиданный охват в lifestyle-нише.'
    ],
    platforms: ['YouTube', 'Telegram', 'TikTok', 'Дзен'],
    audience: ['M · 25–44', 'РФ, города 500K+', 'Технологии, дом, gadget'],
    authors: { total: 9, micro: 4, mid: 4, top: 1 },
    client: {
      name: 'Дмитрий Соколов',
      role: 'Brand Director · PIXELHAUS',
      initials: 'ДС',
      testimonial: '«Получили в 3 раза больше предзаказов, чем планировали. Главное — не баннерная слепота, а реальный интерес. Команда сработала чётко.»'
    },
    video: {
      brand: 'PIXELHAUS',
      author: '@tech_lab',
      url: 'https://www.youtube.com/watch?v=RvBwypGUkPo',
      thumbnail: 'https://img.youtube.com/vi/RvBwypGUkPo/maxresdefault.jpg',
      views: '870K просмотров',
      date: '03.02.2026'
    }
  },
  {
    id: 'auralab',
    brand: 'AURALAB',
    category: 'Косметика · 2024',
    problem: 'Новый бренд натуральной косметики. Доверие к категории низкое, нужна была честная демонстрация эффекта на разных типах кожи.',
    solution: 'Серия 30-дневных дневников у 6 beauty-блогеров с разной кожей. Никакого глянца — только до/после и реальные впечатления.',
    solutionFull: [
      'Подобрали авторов с разными исходными данными: жирная, чувствительная, возрастная, проблемная кожа. Это дало аудитории возможность узнать «свой» сценарий.',
      'Запретили постпродакшн, ретушь и фильтры. Только дневной свет и одинаковый угол съёмки. Это парадоксально подняло доверие в комментах.'
    ],
    platforms: ['Instagram', 'YouTube Shorts', 'Telegram'],
    audience: ['F · 22–45', 'РФ, СНГ', 'Уход, чистый состав, ЗОЖ'],
    authors: { total: 6, micro: 3, mid: 2, top: 1 },
    client: {
      name: 'Мария Лебедева',
      role: 'Founder · AURALAB',
      initials: 'МЛ',
      testimonial: '«Это была лучшая инвестиция за год запуска. Конверсия с блогерского трафика выше, чем с performance, в 4 раза. И возвращаются.»'
    },
    video: {
      brand: 'AURALAB',
      author: '@skin_journal',
      url: 'https://www.youtube.com/watch?v=RvBwypGUkPo',
      thumbnail: 'https://img.youtube.com/vi/RvBwypGUkPo/maxresdefault.jpg',
      views: '2.1M просмотров',
      date: '18.11.2025'
    }
  },
  {
    id: 'fintechplus',
    brand: 'FINTECH+',
    category: 'Банковский продукт · 2025',
    problem: 'Запуск премиальной карты для предпринимателей. Аудитория не верит банковской рекламе и закрывается от прямых продаж.',
    solution: 'Сделали серию интервью с предпринимателями-блогерами о том, как они управляют финансами. Карта — фоном, как часть жизни.',
    solutionFull: [
      'Формат — длинные YouTube-разговоры по 30–60 минут о бизнесе, провалах, найме, налогах. Карта появлялась как естественный инструмент в кадре, без отдельного «рекламного блока».',
      'Поддержали серией коротких роликов в Telegram с цитатами из интервью — это прогрело аудиторию для перехода на лендинг.'
    ],
    platforms: ['YouTube', 'Telegram', 'Подкасты'],
    audience: ['M / F · 30–50', 'РФ, MSK/SPB', 'Бизнес, финансы, инвестиции'],
    authors: { total: 5, micro: 0, mid: 2, top: 3 },
    client: {
      name: 'Игорь Воронцов',
      role: 'CMO · FINTECH+',
      initials: 'ИВ',
      testimonial: '«Заявки от предпринимателей с чеком х5 от среднего. Performance такого качества трафика не приносит. Продлеваем на 2026.»'
    },
    video: {
      brand: 'FINTECH+',
      author: '@business_talk',
      url: 'https://www.youtube.com/watch?v=RvBwypGUkPo',
      thumbnail: 'https://img.youtube.com/vi/RvBwypGUkPo/maxresdefault.jpg',
      views: '420K просмотров',
      date: '22.03.2026'
    }
  },
  {
    id: 'vkuspro',
    brand: 'VKUSPRO',
    category: 'Доставка еды · 2024',
    problem: 'Сервис доставки в регионах. Бренд знают плохо, цены конкурентные, но первый заказ — главный барьер.',
    solution: 'Локальная стратегия: подобрали по 3–4 региональных блогера в каждом из 12 городов запуска. Промокод на первый заказ — у каждого свой.',
    solutionFull: [
      'Регионалы дают эффект «свой человек» — рекомендация воспринимается как от соседа, а не от далёкого лица. Это резко снизило барьер.',
      'Промокоды позволили посчитать вклад каждого города и каждого автора — итеративно отключали неэффективных, добавляли эффективных.'
    ],
    platforms: ['Instagram', 'TikTok', 'VK', 'Telegram'],
    audience: ['M / F · 20–40', 'РФ, города 100–500K', 'Семья, удобство, доставка'],
    authors: { total: 38, micro: 32, mid: 6, top: 0 },
    client: {
      name: 'Светлана Гаврилова',
      role: 'Head of Growth · VKUSPRO',
      initials: 'СГ',
      testimonial: '«38 авторов, 12 городов, понятный CPA по каждому. Это ровно то, что мы хотели от influence — управляемый канал, а не лотерею.»'
    },
    video: {
      brand: 'VKUSPRO',
      author: '@local_food',
      url: 'https://www.youtube.com/watch?v=RvBwypGUkPo',
      thumbnail: 'https://img.youtube.com/vi/RvBwypGUkPo/maxresdefault.jpg',
      views: '3.8M просмотров',
      date: '07.09.2025'
    }
  },
  {
    id: 'cinemus',
    brand: 'CINEMUS',
    category: 'Стриминг-сервис · 2025',
    problem: 'Стриминговая платформа с большой библиотекой, но низкой узнаваемостью молодёжной аудитории. Конкуренция за подписку — жёсткая.',
    solution: 'Сделали серию «киноразборов» с топ-критиками и lifestyle-блогерами вокруг 4 эксклюзивных тайтлов сервиса.',
    solutionFull: [
      'Серьёзные критики разобрали тайтлы по существу — это сформировало интеллектуальный фон бренда.',
      'Lifestyle-авторы показали платформу как «вечернюю привычку» — эмоциональный слой. Серия из 16 единиц контента за месяц.',
      'Дали зрителям бесплатную неделю по уникальной ссылке у каждого автора — отслеживали retention после промо-периода.'
    ],
    platforms: ['YouTube', 'Telegram', 'Instagram', 'Дзен'],
    audience: ['M / F · 18–35', 'РФ', 'Кино, сериалы, поп-культура'],
    authors: { total: 16, micro: 6, mid: 8, top: 2 },
    client: {
      name: 'Антон Беляев',
      role: 'Marketing Lead · CINEMUS',
      initials: 'АБ',
      testimonial: '«Получили +180К новых подписчиков за месяц кампании. Retention на 30 день — 64%, это сильно выше нашего бенчмарка.»'
    },
    video: {
      brand: 'CINEMUS',
      author: '@cinema_room',
      url: 'https://www.youtube.com/watch?v=RvBwypGUkPo',
      thumbnail: 'https://img.youtube.com/vi/RvBwypGUkPo/maxresdefault.jpg',
      views: '1.6M просмотров',
      date: '14.01.2026'
    }
  }
];

/* ---------- RENDER: case detail (Block 3) ---------- */
const caseEls = {
  counter: document.getElementById('case-counter'),
  brand: document.getElementById('case-brand'),
  category: document.getElementById('case-category'),
  problem: document.getElementById('case-problem'),
  solution: document.getElementById('case-solution'),
  solutionFull: document.getElementById('case-solution-full'),
  platforms: document.getElementById('case-platforms'),
  audience: document.getElementById('case-audience'),
  authors: document.getElementById('case-authors'),
  clientPhoto: document.getElementById('case-client-photo'),
  clientName: document.getElementById('case-client-name'),
  clientRole: document.getElementById('case-client-role'),
  testimonial: document.getElementById('case-testimonial'),
  videoLink: document.getElementById('case-video-link'),
  videoThumb: document.getElementById('case-video-thumb'),
  videoBrand: document.getElementById('case-video-brand'),
  videoAuthor: document.getElementById('case-video-author'),
  videoViews: document.getElementById('case-video-views'),
  videoDate: document.getElementById('case-video-date'),
};

let activeCaseId = cases[0].id;

function renderCase(id) {
  const idx = cases.findIndex(c => c.id === id);
  if (idx === -1) return;
  const c = cases[idx];
  activeCaseId = id;

  caseEls.counter.textContent = `/ ${String(idx + 1).padStart(2, '0')} / ${String(cases.length).padStart(2, '0')}`;
  caseEls.brand.textContent = c.brand;
  caseEls.category.textContent = '/ ' + c.category;
  caseEls.problem.textContent = c.problem;
  caseEls.solution.textContent = c.solution;

  caseEls.solutionFull.innerHTML = c.solutionFull.map(p => `<p>${p}</p>`).join('');

  caseEls.platforms.innerHTML = c.platforms.map(p => `<li>${p}</li>`).join('');
  caseEls.audience.innerHTML  = c.audience.map(a => `<li>${a}</li>`).join('');

  const a = c.authors;
  const tiers = [
    a.micro && `${a.micro} микро`,
    a.mid   && `${a.mid} миддл`,
    a.top   && `${a.top} топ`
  ].filter(Boolean);
  caseEls.authors.innerHTML = `
    <span class="case__authors-total">${a.total} АВТОРОВ</span>
    ${tiers.map((t, i) => `
      <span class="case__authors-divider">${i === 0 ? '/' : '·'}</span>
      <span>${t}</span>
    `).join('')}
  `;

  caseEls.clientPhoto.textContent = c.client.initials;
  caseEls.clientName.textContent = c.client.name;
  caseEls.clientRole.textContent = c.client.role;
  caseEls.testimonial.textContent = c.client.testimonial;

  caseEls.videoLink.href = c.video.url;
  caseEls.videoThumb.style.backgroundImage = c.video.thumbnail ? `url('${c.video.thumbnail}')` : '';
  caseEls.videoBrand.textContent = c.video.brand;
  caseEls.videoAuthor.textContent = c.video.author;
  caseEls.videoViews.textContent = c.video.views;
  caseEls.videoDate.textContent = c.video.date;

  // Update active state in grid
  document.querySelectorAll('.case-card').forEach(el => {
    el.classList.toggle('is-active', el.dataset.caseId === id);
  });
}

/* ---------- RENDER: cases grid (Block 4) ---------- */
const grid = document.getElementById('cases-grid');
grid.innerHTML = cases.map((c, i) => `
  <article class="case-card" data-case-id="${c.id}" tabindex="0" role="button" aria-label="Открыть кейс ${c.brand}">
    <div class="case-card__inner">
      <span class="case-card__num">[${String(i + 1).padStart(2, '0')} / ${String(cases.length).padStart(2, '0')}]</span>
      <div>
        <h3 class="case-card__brand">${c.brand}</h3>
        <div class="case-card__meta">
          <span>${c.category.split(' · ')[0]}</span>
          <span class="case-card__arrow">→</span>
        </div>
      </div>
    </div>
  </article>
`).join('');

/* ---------- INTERACTIONS ---------- */

// Case card click → switch active case + scroll to detail
document.querySelectorAll('.case-card').forEach(card => {
  const trigger = () => {
    const id = card.dataset.caseId;
    if (id === activeCaseId) return;
    renderCase(id);
    document.getElementById('case-detail').scrollIntoView({
      behavior: 'smooth', block: 'start'
    });
  };
  card.addEventListener('click', trigger);
  card.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      trigger();
    }
  });
});

// Flip cards
document.querySelectorAll('.flip-card').forEach(card => {
  const toggle = () => {
    const flipped = card.classList.toggle('is-flipped');
    card.setAttribute('aria-pressed', flipped);
  };
  card.addEventListener('click', toggle);
  card.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      toggle();
    }
  });
});

// Case accordion
const accordionToggle = document.querySelector('.case__accordion-toggle');
if (accordionToggle) {
  accordionToggle.addEventListener('click', () => {
    const expanded = accordionToggle.getAttribute('aria-expanded') === 'true';
    accordionToggle.setAttribute('aria-expanded', !expanded);
  });
}

// Mobile burger
const burger = document.querySelector('.header__burger');
const header = document.querySelector('.header');
if (burger) {
  burger.addEventListener('click', () => {
    const open = header.classList.toggle('is-open');
    burger.setAttribute('aria-expanded', open);
  });
  document.querySelectorAll('.header__nav a').forEach(a => {
    a.addEventListener('click', () => {
      header.classList.remove('is-open');
      burger.setAttribute('aria-expanded', false);
    });
  });
}

// Form
const form = document.getElementById('contact-form');
const formResult = document.getElementById('form-result');

form.addEventListener('submit', e => {
  e.preventDefault();

  // Clear previous invalid states
  form.querySelectorAll('.field').forEach(f => f.classList.remove('is-invalid'));

  let valid = true;
  form.querySelectorAll('input[required], textarea[required]').forEach(input => {
    if (!input.value.trim()) {
      input.closest('.field').classList.add('is-invalid');
      valid = false;
    }
  });

  if (!valid) {
    const firstInvalid = form.querySelector('.field.is-invalid input, .field.is-invalid textarea');
    if (firstInvalid) firstInvalid.focus();
    return;
  }

  // Mock submit — in production this POSTs to backend that:
  //  1) saves to DB / admin panel
  //  2) sends to Telegram bot via webhook
  console.log('FORM SUBMIT (mock):', Object.fromEntries(new FormData(form)));

  form.style.display = 'none';
  formResult.hidden = false;
  formResult.scrollIntoView({ behavior: 'smooth', block: 'center' });

  setTimeout(() => {
    form.reset();
    form.style.display = '';
    formResult.hidden = true;
  }, 6000);
});

/* ---------- INIT ---------- */
renderCase(cases[0].id);
