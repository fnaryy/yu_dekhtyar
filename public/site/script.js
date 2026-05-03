/* ============================================================
   ЮРИЙ ДЕХТЯР — interactions
   Reads case data from window.SITE_CASES (injected by Blade).
   ============================================================ */

const cases = Array.isArray(window.SITE_CASES) ? window.SITE_CASES : [];

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

let activeCaseId = cases[0]?.id;

function escapeHtml(s) {
  return String(s ?? '').replace(/[&<>"']/g, c => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
  }[c]));
}

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

  caseEls.solutionFull.innerHTML = (c.solutionFull || []).map(p => `<p>${escapeHtml(p)}</p>`).join('');
  caseEls.platforms.innerHTML = (c.platforms || []).map(p => `<li>${escapeHtml(p)}</li>`).join('');
  caseEls.audience.innerHTML  = (c.audience || []).map(a => `<li>${escapeHtml(a)}</li>`).join('');

  const a = c.authors || { total: 0 };
  const tiers = [
    a.micro && `${a.micro} микро`,
    a.mid   && `${a.mid} миддл`,
    a.top   && `${a.top} топ`
  ].filter(Boolean);
  caseEls.authors.innerHTML = `
    <span class="case__authors-total">${a.total} АВТОРОВ</span>
    ${tiers.map((t, i) => `
      <span class="case__authors-divider">${i === 0 ? '/' : '·'}</span>
      <span>${escapeHtml(t)}</span>
    `).join('')}
  `;

  // Client photo: img if uploaded, else initials
  const client = c.client || {};
  caseEls.clientPhoto.innerHTML = client.photo
    ? `<img src="${escapeHtml(client.photo)}" alt="${escapeHtml(client.name || '')}">`
    : escapeHtml(client.initials || '');
  caseEls.clientName.textContent = client.name || '';
  caseEls.clientRole.textContent = client.role || '';
  caseEls.testimonial.textContent = client.testimonial || '';

  const v = c.video || {};
  caseEls.videoLink.href = v.url || '#';
  caseEls.videoThumb.style.backgroundImage = v.thumbnail ? `url('${v.thumbnail}')` : '';
  caseEls.videoBrand.textContent = v.brand || '';
  caseEls.videoAuthor.textContent = v.author || '';
  caseEls.videoViews.textContent = v.views || '';
  caseEls.videoDate.textContent = v.date || '';

  // Update active state in grid
  document.querySelectorAll('.case-card').forEach(el => {
    el.classList.toggle('is-active', el.dataset.caseId === id);
  });
}

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

// Form — POSTs JSON, expects { ok: true } back. Backend wired in Phase 5.
const form = document.getElementById('contact-form');
const formResult = document.getElementById('form-result');

if (form) {
  form.addEventListener('submit', async e => {
    e.preventDefault();

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

    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'ОТПРАВЛЯЕМ…';

    try {
      const formData = new FormData(form);
      const csrfToken = formData.get('_token');

      const response = await fetch(form.action, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData,
      });

      if (response.ok) {
        form.style.display = 'none';
        formResult.hidden = false;
        formResult.scrollIntoView({ behavior: 'smooth', block: 'center' });

        setTimeout(() => {
          form.reset();
          form.style.display = '';
          formResult.hidden = true;
          submitBtn.disabled = false;
          submitBtn.textContent = originalText;
        }, 6000);
      } else if (response.status === 422) {
        const data = await response.json();
        Object.keys(data.errors || {}).forEach(name => {
          const input = form.querySelector(`[name="${name}"]`);
          if (input) input.closest('.field')?.classList.add('is-invalid');
        });
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      } else {
        throw new Error('Server error');
      }
    } catch (err) {
      alert('Не получилось отправить заявку. Попробуйте ещё раз или напишите напрямую в Telegram.');
      submitBtn.disabled = false;
      submitBtn.textContent = originalText;
    }
  });
}

/* ---------- INIT ---------- */
if (cases.length > 0) {
  renderCase(cases[0].id);
}
