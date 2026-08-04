document.querySelectorAll( '[data-tilt-card]' ).forEach( ( card ) => {
	const inner = card.querySelector( '.pg-price-card-inner' );

	if ( ! inner ) {
		return;
	}

	const clearTransform = () => {
		inner.style.transform = '';
	};

	card.addEventListener( 'pointermove', ( event ) => {
		const box      = card.getBoundingClientRect();
		const rotateX  = ( 0.5 - ( event.clientY - box.top ) / box.height ) * 12;
		const rotateY  = ( ( event.clientX - box.left ) / box.width - 0.5 ) * 12;

		inner.style.transform = `rotateX(${ rotateX }deg) rotateY(${ rotateY }deg)`;
	} );
	card.addEventListener( 'pointerleave', clearTransform );
} );
