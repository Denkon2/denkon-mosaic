/**
 * Mobile primary navigation toggle.
 */
( function() {
	'use strict';

	function initMobileMenu( toggle ) {
		var navigationId = toggle.getAttribute( 'aria-controls' );
		var navigation   = navigationId ? document.getElementById( navigationId ) : null;

		if ( ! navigation ) {
			return;
		}

		toggle.addEventListener( 'click', function() {
			var isOpen = navigation.classList.toggle( 'is-open' );

			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	}

	function initialize() {
		var toggles = document.querySelectorAll( '.site-header__menu-toggle' );

		for ( var index = 0; index < toggles.length; index++ ) {
			initMobileMenu( toggles[ index ] );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initialize );
	} else {
		initialize();
	}
}() );
