(function () {
	'use strict';

	/* ---------- Header : ombre au scroll ---------- */
	var header = document.getElementById( 'cb-header' );
	function onScroll() {
		if ( ! header ) return;
		if ( window.scrollY > 20 ) {
			header.classList.add( 'is-scrolled' );
		} else {
			header.classList.remove( 'is-scrolled' );
		}
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();

	/* ---------- Menu mobile ---------- */
	var toggle = document.getElementById( 'cb-nav-toggle' );
	var nav = document.getElementById( 'cb-nav' );
	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'is-open' );
			toggle.classList.toggle( 'is-active', open );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );

		// Sous-menu "Métier" au clic en mobile
		var dropdownParents = nav.querySelectorAll( '.menu-item-has-children' );
		dropdownParents.forEach( function ( li ) {
			var link = li.querySelector( ':scope > a' );
			if ( ! link ) return;
			link.addEventListener( 'click', function ( e ) {
				if ( window.innerWidth <= 767 ) {
					e.preventDefault();
					li.classList.toggle( 'is-open' );
				}
			} );
		} );
	}

	/* ---------- Slider hero (accueil) ---------- */
	var hero = document.getElementById( 'cb-hero' );
	if ( hero ) {
		var slides = hero.querySelectorAll( '.cb-hero__slide' );
		var dots = hero.querySelectorAll( '.cb-hero__dot' );
		var prevBtn = hero.querySelector( '.cb-hero__arrow--prev' );
		var nextBtn = hero.querySelector( '.cb-hero__arrow--next' );
		var current = 0;
		var timer = null;

		function goTo( index ) {
			if ( ! slides.length ) return;
			current = ( index + slides.length ) % slides.length;
			slides.forEach( function ( s, i ) { s.classList.toggle( 'is-active', i === current ); } );
			dots.forEach( function ( d, i ) { d.classList.toggle( 'is-active', i === current ); } );
		}
		function next() { goTo( current + 1 ); }
		function prev() { goTo( current - 1 ); }
		function restartTimer() {
			if ( timer ) clearInterval( timer );
			timer = setInterval( next, 6000 );
		}

		if ( prevBtn ) prevBtn.addEventListener( 'click', function () { prev(); restartTimer(); } );
		if ( nextBtn ) nextBtn.addEventListener( 'click', function () { next(); restartTimer(); } );
		dots.forEach( function ( dot, i ) {
			dot.addEventListener( 'click', function () { goTo( i ); restartTimer(); } );
		} );

		if ( slides.length > 1 ) restartTimer();
	}

	/* ---------- Fade-in au scroll ---------- */
	var revealSelectors = [
		'.cb-qsn__head', '.cb-qsn__body',
		'.cb-metier-card', '.cb-client-card',
		'.cb-real-card', '.cb-job-card',
		'.cb-quote', '.cb-partenaires__grid'
	];
	var revealEls = document.querySelectorAll( revealSelectors.join( ',' ) );
	if ( 'IntersectionObserver' in window && revealEls.length ) {
		revealEls.forEach( function ( el ) { el.classList.add( 'cb-reveal' ); } );
		var io = new IntersectionObserver( function ( entries, observer ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					observer.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' } );
		revealEls.forEach( function ( el ) { io.observe( el ); } );
	} else {
		revealEls.forEach( function ( el ) { el.classList.add( 'cb-reveal', 'is-visible' ); } );
	}

	/* ---------- Lightbox galerie réalisations ---------- */
	var galleryButtons = document.querySelectorAll( '[data-gallery]' );
	var activeLightbox = null;
	var activeIndex = 0;

	function closeLightbox() {
		if ( activeLightbox ) {
			activeLightbox.setAttribute( 'hidden', '' );
			activeLightbox = null;
		}
	}
	function showImage( index ) {
		if ( ! activeLightbox ) return;
		var slides = activeLightbox.querySelectorAll( '.cb-lightbox__slide' );
		activeIndex = ( index + slides.length ) % slides.length;
		slides.forEach( function ( slide, i ) { slide.classList.toggle( 'is-active', i === activeIndex ); } );
		var counter = activeLightbox.querySelector( '.cb-lightbox__counter' );
		if ( counter ) counter.textContent = ( activeIndex + 1 ) + ' / ' + slides.length;
	}

	galleryButtons.forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var id = btn.getAttribute( 'data-gallery' );
			var lightbox = document.getElementById( id );
			if ( ! lightbox ) return;

			if ( ! lightbox.querySelector( '.cb-lightbox__close' ) ) {
				var close = document.createElement( 'button' );
				close.type = 'button';
				close.className = 'cb-lightbox__close';
				close.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>';
				close.addEventListener( 'click', closeLightbox );
				lightbox.appendChild( close );

				var slides = lightbox.querySelectorAll( '.cb-lightbox__slide' );
				if ( slides.length > 1 ) {
					var prev = document.createElement( 'button' );
					prev.type = 'button';
					prev.className = 'cb-lightbox__nav cb-lightbox__nav--prev';
					prev.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
					prev.addEventListener( 'click', function () { showImage( activeIndex - 1 ); } );

					var nextB = document.createElement( 'button' );
					nextB.type = 'button';
					nextB.className = 'cb-lightbox__nav cb-lightbox__nav--next';
					nextB.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
					nextB.addEventListener( 'click', function () { showImage( activeIndex + 1 ); } );

					lightbox.appendChild( prev );
					lightbox.appendChild( nextB );

					var counterEl = document.createElement( 'div' );
					counterEl.className = 'cb-lightbox__counter';
					lightbox.appendChild( counterEl );
				}

				lightbox.addEventListener( 'click', function ( e ) {
					if ( e.target === lightbox ) closeLightbox();
				} );
			}

			lightbox.removeAttribute( 'hidden' );
			activeLightbox = lightbox;
			showImage( 0 );
		} );
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( ! activeLightbox ) return;
		if ( e.key === 'Escape' ) closeLightbox();
		if ( e.key === 'ArrowRight' ) showImage( activeIndex + 1 );
		if ( e.key === 'ArrowLeft' ) showImage( activeIndex - 1 );
	} );

})();
