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

	if ( ! track ) {
		return;
	}

	let dragging     = false;
	let touching     = false;
	let startX       = 0;
	let startScroll  = 0;
	let pauseUntil   = 0;
	let direction    = 1;
	let lastFrame    = 0;
	let autoPosition = track.scrollLeft;
	let isVisible    = true;

	const pause = ( duration = 2200 ) => {
		pauseUntil = Math.max( pauseUntil, performance.now() + duration );
	};

	const stopDragging = ( pointerId ) => {
		if ( dragging && typeof pointerId === 'number' && track.hasPointerCapture( pointerId ) ) {
			track.releasePointerCapture( pointerId );
		}

		dragging = false;
		track.classList.remove( 'is-dragging' );
		cursor?.classList.remove( 'is-active' );
		autoPosition = track.scrollLeft;
	};

	track.addEventListener( 'pointerdown', ( event ) => {
		if ( event.pointerType === 'touch' ) {
			touching = true;
			pause( 2600 );
			return;
		}

		pause( 800 );
		dragging    = true;
		startX      = event.clientX;
		startScroll = track.scrollLeft;

		track.classList.add( 'is-dragging' );
		cursor?.classList.add( 'is-active' );
		track.setPointerCapture( event.pointerId );
	} );

	track.addEventListener( 'pointermove', ( event ) => {
		if ( dragging ) {
			track.scrollLeft = startScroll - ( event.clientX - startX );
		}
	} );

	track.addEventListener( 'pointerleave', ( event ) => {
		if ( event.pointerType !== 'touch' && dragging ) {
			stopDragging( event.pointerId );
			pause( 1600 );
		}
	} );
	track.addEventListener( 'pointerup', ( event ) => {
		touching = false;
		stopDragging( event.pointerId );
		pause( 2000 );
	} );
	track.addEventListener( 'pointercancel', ( event ) => {
		touching = false;
		stopDragging( event.pointerId );
		pause( 2000 );
	} );
	track.addEventListener( 'wheel', () => pause( 1800 ), { passive: true } );

	if ( 'IntersectionObserver' in window ) {
		const observer = new IntersectionObserver( ( entries ) => {
			isVisible = entries[0]?.isIntersecting ?? true;
			autoPosition = track.scrollLeft;
		}, { threshold: 0.1 } );

		observer.observe( track );
	}

	const autoScroll = ( time ) => {
		const maximumScroll = track.scrollWidth - track.clientWidth;
		const elapsed       = lastFrame ? Math.min( time - lastFrame, 40 ) : 0;
		lastFrame          = time;

		if ( ! dragging && ! touching && isVisible && ! document.hidden && time > pauseUntil && maximumScroll > 0 ) {
			autoPosition += elapsed * 0.035 * direction;

			if ( autoPosition >= maximumScroll ) {
				track.scrollLeft = maximumScroll;
				autoPosition     = maximumScroll;
				direction        = -1;
				pause( 900 );
			} else if ( autoPosition <= 0 ) {
				track.scrollLeft = 0;
				autoPosition     = 0;
				direction        = 1;
				pause( 900 );
			} else {
				track.scrollLeft = autoPosition;
			}
		} else {
			autoPosition = track.scrollLeft;
		}

		requestAnimationFrame( autoScroll );
	};

	requestAnimationFrame( autoScroll );
})();
