(() => {
	'use strict';

	const media = document.querySelector( '[data-magnifier]' );

	if ( media ) {
		const image = media.querySelector( 'img' );
		const lens  = media.querySelector( '.pg-about-mission__lens' );

		const updateLens = ( event ) => {
			const box = media.getBoundingClientRect();
			const x   = event.clientX - box.left;
			const y   = event.clientY - box.top;

			lens.style.left            = `${ x }px`;
			lens.style.top             = `${ y }px`;
			lens.style.backgroundImage = `url("${ image.currentSrc || image.src }")`;
			lens.style.backgroundSize  = `${ box.width * 2.8 }px ${ box.height * 2.8 }px`;
			lens.style.backgroundPosition = `${ -( x * 2.8 - lens.offsetWidth / 2 ) }px ${ -( y * 2.8 - lens.offsetHeight / 2 ) }px`;
		};

		media.addEventListener( 'pointerenter', ( event ) => {
			updateLens( event );
			lens.classList.add( 'is-visible' );
		} );
		media.addEventListener( 'pointermove', updateLens );
		media.addEventListener( 'pointerleave', () => lens.classList.remove( 'is-visible' ) );
	}

	const track  = document.querySelector( '.pg-about-team__track' );
	const cursor = document.querySelector( '.pg-about-team__cursor' );

	if ( ! track || ! cursor ) {
		return;
	}

	let dragging    = false;
	let startX      = 0;
	let startScroll = 0;
	let pauseUntil  = 0;
	let direction   = 1;

	const pause = ( duration = 2200 ) => {
		pauseUntil = performance.now() + duration;
	};

	const stopDragging = () => {
		dragging = false;
		track.classList.remove( 'is-dragging' );
		cursor.classList.remove( 'is-active' );
	};

	track.addEventListener( 'pointerdown', ( event ) => {
		pause( 400 );
		dragging    = true;
		startX      = event.clientX;
		startScroll = track.scrollLeft;

		track.classList.add( 'is-dragging' );
		cursor.classList.add( 'is-active' );
		track.setPointerCapture( event.pointerId );
	} );

	track.addEventListener( 'pointermove', ( event ) => {
		if ( dragging ) {
			track.scrollLeft = startScroll - ( event.clientX - startX );
		}
	} );

	track.addEventListener( 'pointerleave', () => {
		stopDragging();
		pause( 160 );
	} );
	track.addEventListener( 'pointerup', () => {
		stopDragging();
		pause( 160 );
	} );
	track.addEventListener( 'pointercancel', () => {
		stopDragging();
		pause( 160 );
	} );

	const autoScroll = ( time ) => {
		const maximumScroll = track.scrollWidth - track.clientWidth;

		if ( ! dragging && time > pauseUntil && maximumScroll > 0 ) {
			const nextScroll = track.scrollLeft + 0.55 * direction;

			if ( nextScroll >= maximumScroll ) {
				track.scrollLeft = maximumScroll;
				direction        = -1;
				pause( 900 );
			} else if ( nextScroll <= 0 ) {
				track.scrollLeft = 0;
				direction        = 1;
				pause( 900 );
			} else {
				track.scrollLeft = nextScroll;
			}
		}

		requestAnimationFrame( autoScroll );
	};

	requestAnimationFrame( autoScroll );
})();
