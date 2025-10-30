// Adiciona um botão clicável sobre o ícone de calendário (background SVG) dos inputs
// Sem modificar o HTML: o script envolve cada input .date-field em um wrapper e injeta
// um botão posicionado sobre a área do ícone.
document.addEventListener('DOMContentLoaded', () => {
	const inputs = document.querySelectorAll('.input-grupo .date-field');
	inputs.forEach(input => {
		// evita duplicar caso já processado
		if (input.closest('.date-wrapper')) return;

		// cria wrapper
		const wrapper = document.createElement('span');
		wrapper.className = 'date-wrapper';
		wrapper.style.position = 'relative';
		wrapper.style.display = getComputedStyle(input).display === 'block' ? 'block' : 'inline-block';

		// insere wrapper antes do input e move o input para dentro
		input.parentNode.insertBefore(wrapper, input);
		wrapper.appendChild(input);

		// cria botão overlay
		const btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'calendar-overlay';
		btn.setAttribute('aria-label', 'Abrir calendário');
		btn.innerHTML = '';
		// styling via CSS no arquivo style.css; aqui só adicionamos o elemento
		wrapper.appendChild(btn);

		// clique: tenta abrir picker nativo. Se input não for type=date, alterna temporariamente.
		btn.addEventListener('click', (e) => {
			e.preventDefault();
			// Se o input já é date e browser suporta showPicker, use
			const prevType = input.type;
			const supportsShow = typeof input.showPicker === 'function';

			if (input.type !== 'date') {
				try {
					input.type = 'date';
				} catch (err) {
					// alguns navegadores podem lançar — ignore
				}
			}

			if (supportsShow) {
				try {
					input.showPicker();
				} catch (err) {
					// fallback para focus
					input.focus();
				}
			} else {
				// fallback: focus (em muitos navegadores abre o seletor)
				input.focus();
			}

			// ao perder o foco, restaura o tipo original se alteramos
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
