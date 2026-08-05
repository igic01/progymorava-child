(() => {
  'use strict';

  const calculator = document.querySelector('.pg-calc');
  const offHours = document.querySelector('#pg-calc-hours-off');
  const primeHours = document.querySelector('#pg-calc-hours-prime');

  if (!calculator || !offHours || !primeHours) {
    return;
  }

  const parseNumber = (value) => {
    const normalized = String(value)
      .replace(/\u00a0/g, '')
      .replace(/\s/g, '')
      .replace(',', '.');
    const match = normalized.match(/\d+(?:\.\d+)?/);

    return match ? Number(match[0]) : Number.NaN;
  };

  const parseRange = (value) => {
    const matches = String(value).match(/\d+(?:[.,]\d+)?/g);

    if (!matches || !matches.length) {
      return null;
    }

    const values = matches.map((number) => Number(number.replace(',', '.')));

    return {
      min: values[0],
      max: String(value).includes('+') ? Number.POSITIVE_INFINITY : (values[1] ?? values[0]),
    };
  };

  const tableRows = Array.from(
    calculator.querySelectorAll('.pg-calc__table-content table tbody tr')
  );
  const tiers = tableRows.map((row) => {
    const cells = Array.from(row.cells);
    const range = cells[0] ? parseRange(cells[0].textContent) : null;
    const offRate = cells[2] ? parseNumber(cells[2].textContent) : Number.NaN;
    const primeRate = cells[3] ? parseNumber(cells[3].textContent) : Number.NaN;

    if (!range || !Number.isFinite(offRate) || !Number.isFinite(primeRate)) {
      return null;
    }

    return {
      ...range,
      rangeLabel: cells[0].textContent.trim(),
      discountLabel: cells[1] ? cells[1].textContent.trim() : '—',
      offRate,
      primeRate,
      row,
    };
  }).filter(Boolean);

  const baseOffRate = Math.max(0, Number(calculator.dataset.offRate) || 0);
  const basePrimeRate = Math.max(0, Number(calculator.dataset.primeRate) || 0);
  const currentLabel = calculator.dataset.currentLabel || 'Aktuálne nastavenie';
  const emptyMessage = calculator.dataset.emptyMessage || 'Zadajte počet hodín pre výpočet ceny.';
  const hoursSuffix = calculator.dataset.hoursSuffix || 'hod.';
  const money = (value) => new Intl.NumberFormat('sk-SK', {
    style: 'currency',
    currency: 'EUR',
  }).format(value);
  const totalHours = document.querySelector('#pg-calc-total-hours');
  const fullPrice = document.querySelector('#pg-calc-full-price');
  const saving = document.querySelector('#pg-calc-saving');
  const finalPrice = document.querySelector('#pg-calc-final-price');
  const tierInfo = document.querySelector('#pg-calc-tier');

  const renderTierInfo = (tier, total) => {
    const heading = document.createElement('div');
    const headingLabel = document.createElement('span');
    const headingValue = document.createElement('strong');
    const description = document.createElement('div');
    const descriptionText = document.createElement('span');

    headingLabel.textContent = currentLabel;
    headingValue.textContent = tier ? tier.discountLabel : '—';
    descriptionText.textContent = total === 0
      ? emptyMessage
      : tier
        ? `${tier.rangeLabel}: ${tier.discountLabel}`
        : emptyMessage;

    heading.append(headingLabel, headingValue);
    description.append(descriptionText);
    tierInfo.replaceChildren(heading, description);
  };

  const update = () => {
    const off = Math.max(0, Number(offHours.value) || 0);
    const prime = Math.max(0, Number(primeHours.value) || 0);
    const total = off + prime;
    const tier = tiers.find((item) => total >= item.min && total <= item.max) || null;
    const standard = off * baseOffRate + prime * basePrimeRate;
    const calculated = tier ? off * tier.offRate + prime * tier.primeRate : standard;
    const usesHigherFixedRate = Boolean(
      tier && (tier.offRate > baseOffRate || tier.primeRate > basePrimeRate)
    );
    const full = usesHigherFixedRate ? calculated : standard;
    const saved = Math.max(0, full - calculated);

    totalHours.textContent = `${total} ${hoursSuffix}`;
    fullPrice.textContent = money(full);
    saving.textContent = saved > 0 ? money(saved) : '—';
    finalPrice.textContent = money(calculated);
    renderTierInfo(tier, total);

    tableRows.forEach((row) => {
      row.classList.toggle('is-active', Boolean(tier && tier.row === row));
    });
  };

  [offHours, primeHours].forEach((input) => input.addEventListener('input', update));
  update();
})();
