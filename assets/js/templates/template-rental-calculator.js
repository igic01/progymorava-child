(() => {
  const tiers = [
    { min: 0, max: 0, discount: 0, label: 'Zadajte počet hodín pre výpočet ceny.' },
    { min: 1, max: 2, short: true, range: '1–2 hod.', label: 'Krátky prenájom: jednotná sadzba 20 € / hod.' },
    { min: 3, max: 9, discount: 0, range: '3–9 hod.', label: '3–9 hodín mesačne: štandardná sadzba.' },
    { min: 10, max: 19, discount: 5, range: '10–19 hod.', label: '10–19 hodín mesačne: získavate 5 % zľavu.' },
    { min: 20, max: 29, discount: 10, range: '20–29 hod.', label: '20–29 hodín mesačne: získavate 10 % zľavu.' },
    { min: 30, max: 49, discount: 15, range: '30–49 hod.', label: '30–49 hodín mesačne: získavate 15 % zľavu.' },
    { min: 50, max: Infinity, discount: 20, range: '50+ hod.', label: '50+ hodín mesačne: získavate 20 % zľavu.' },
  ];

  const offHours = document.querySelector( '#pg-calc-hours-off' );
  const primeHours = document.querySelector( '#pg-calc-hours-prime' );

  if ( ! offHours || ! primeHours ) {
    return;
  }

  const money = ( value ) => new Intl.NumberFormat( 'sk-SK', { style: 'currency', currency: 'EUR' } ).format( value );
  const totalHours = document.querySelector( '#pg-calc-total-hours' );
  const fullPrice = document.querySelector( '#pg-calc-full-price' );
  const saving = document.querySelector( '#pg-calc-saving' );
  const finalPrice = document.querySelector( '#pg-calc-final-price' );
  const tierInfo = document.querySelector( '#pg-calc-tier' );
  const discountRows = document.querySelector( '#pg-calc-discount-rows' );

  const update = () => {
    const off = Math.max( 0, Number( offHours.value ) || 0 );
    const prime = Math.max( 0, Number( primeHours.value ) || 0 );
    const total = off + prime;
    const tier = tiers.find( ( item ) => total >= item.min && total <= item.max );
    const standard = off * 10 + prime * 15;
    const full = tier.short ? total * 20 : standard;
    const final = tier.short ? full : full * ( 1 - tier.discount / 100 );

    totalHours.textContent = `${ total } hod.`;
    fullPrice.textContent = money( full );
    saving.textContent = final === full ? '—' : money( full - final );
    finalPrice.textContent = money( final );
    tierInfo.innerHTML = `<div><span>Aktuálne nastavenie</span><strong>${ tier.short ? '20 € / hod.' : tier.discount ? `−${ tier.discount } %` : 'Bez zľavy' }</strong></div><div><span>${ tier.label }</span></div>`;
    discountRows.innerHTML = tiers.slice( 1 ).map( ( item ) => {
      const isActive = item === tier;
      const offPeakRate = item.short ? '20,00 €' : money( 10 * ( 1 - item.discount / 100 ) );
      const primeRate = item.short ? '20,00 €' : money( 15 * ( 1 - item.discount / 100 ) );
      const discount = item.short ? '<span class="pg-calc__short-rate">20 € / hod.</span>' : item.discount ? `<span class="pg-calc__discount">−${ item.discount } %</span>` : '—';

      return `<tr${ isActive ? ' class="is-active"' : '' }><td>${ item.range }${ isActive ? ' ◀' : '' }</td><td>${ discount }</td><td>${ offPeakRate }</td><td>${ primeRate }</td></tr>`;
    } ).join( '' );
  };

  [ offHours, primeHours ].forEach( ( input ) => input.addEventListener( 'input', update ) );
  update();
})();
