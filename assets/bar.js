( function () {
	var bar = document.getElementById( 'no-black-friday' );
	var key = 'no-black-friday-closed';
	var closed = null;

	// Storage can be blocked by the browser.
	try {
		closed = localStorage.getItem( key );
	} catch ( e ) {}

	if ( closed === bar.dataset.year || ( bar.dataset.until && Date.now() >= bar.dataset.until * 1000 ) ) {
		bar.remove();

		return;
	}

	bar.querySelector( '.nbf__close' ).addEventListener( 'click', function () {
		try {
			localStorage.setItem( key, bar.dataset.year );
		} catch ( e ) {}

		bar.remove();
	} );
} )();
