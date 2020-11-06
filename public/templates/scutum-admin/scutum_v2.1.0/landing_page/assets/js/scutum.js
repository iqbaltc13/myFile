function addClass (el, className) {
	if (el.classList) {
		el.classList.add(className);
	} else if (!hasClass(el, className)) {
		el.className += " " + className
	}
}

function removeClass (el, className) {
	if (el.classList) {
		el.classList.remove(className);
	} else if (hasClass(el, className)) {
		var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
		el.className = el.className.replace(reg, ' ')
	}
}

function hasClass(el, className) {
	if (el.classList) {
		return el.classList.contains(className)
	} else {
		return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'))
	}
}

// input events
UIkit.util.on('input, textarea', 'blur', function () {
	if (this.value === '') {
		removeClass(this, 'sc-input-filled');
	}
	else {
		addClass(this, 'sc-input-filled');
	}
});

// hide offcanvas on scrolled
UIkit.util.on('.sc-js-scroll-trigger', 'scrolled', function () {
	UIkit.offcanvas('#sc-nav-mobile').hide();
});