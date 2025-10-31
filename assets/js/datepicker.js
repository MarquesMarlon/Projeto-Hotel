document.addEventListener('DOMContentLoaded', () => {
	const inputs = document.querySelectorAll('.input-grupo .date-field');
	inputs.forEach(input => {
		// evita duplicar caso já PROCESSADO
		if (input.closest('.date-wrapper')) return;

	
		const wrapper = document.createElement('span');
		wrapper.className = 'date-wrapper';
		wrapper.style.position = 'relative';
		wrapper.style.display = getComputedStyle(input).display === 'block' ? 'block' : 'inline-block';

		input.parentNode.insertBefore(wrapper, input);
		wrapper.appendChild(input);

		const btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'calendar-overlay';
		btn.setAttribute('aria-label', 'Abrir calendário');
		btn.innerHTML = '';
	
		wrapper.appendChild(btn);


		btn.addEventListener('click', (e) => {
			e.preventDefault();
		
			const prevType = input.type;
			const supportsShow = typeof input.showPicker === 'function';

			if (input.type !== 'date') {
				try {
					input.type = 'date';
				} catch (err) {
				
				}
			}

			if (supportsShow) {
				try {
					input.showPicker();
				} catch (err) {
		
					input.focus();
				}
			} else {
		
				input.focus();
			}

		
			if (prevType !== input.type) {
				const restore = () => {
					try { input.type = prevType; } catch (err) { }
					input.removeEventListener('blur', restore);
				};
				input.addEventListener('blur', restore);
			}
		});
	});
});
