import './bootstrap';
import { createIcons, icons } from 'lucide';

const animationContexts = new WeakMap();
let animationFrameId = null;
let gsapModulesPromise = null;
let livewireHooksRegistered = false;
const reducedMotionMediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

const revealPresets = {
	lift: {
		from: { y: 28, autoAlpha: 0 },
		to: { y: 0, autoAlpha: 1, duration: 0.56, ease: 'power2.out' },
	},
	drift: {
		from: { x: -26, autoAlpha: 0 },
		to: { x: 0, autoAlpha: 1, duration: 0.58, ease: 'power3.out' },
	},
	pop: {
		from: { y: 16, scale: 0.96, autoAlpha: 0 },
		to: { y: 0, scale: 1, autoAlpha: 1, duration: 0.52, ease: 'back.out(1.3)' },
	},
	tilt: {
		from: { y: 22, rotate: -2.5, autoAlpha: 0 },
		to: { y: 0, rotate: 0, autoAlpha: 1, duration: 0.56, ease: 'expo.out' },
	},
	soft: {
		from: { y: 14, autoAlpha: 0 },
		to: { y: 0, autoAlpha: 1, duration: 0.42, ease: 'sine.out' },
	},
};

function initLucideIcons() {
	createIcons({ icons });
}

function clearAnimationContext(page) {
	if (!page) {
		return;
	}

	const existingContext = animationContexts.get(page);

	if (existingContext) {
		existingContext.revert();
		animationContexts.delete(page);
	}
}

function isReducedMotion() {
	return reducedMotionMediaQuery.matches;
}

function shouldRunAnimations() {
	return Boolean(document.querySelector('[data-projects-page], [data-home-page]'));
}

function triggerOnce(gsap, target, vars, start = 'top 90%') {
	if (!target) {
		return;
	}

	gsap.from(target, {
		...vars,
		force3D: true,
		scrollTrigger: {
			trigger: target,
			start,
			once: true,
		},
	});
}

function batchReveal(gsap, ScrollTrigger, elements, presetName, options = {}) {
	if (elements.length === 0) {
		return;
	}

	const preset = revealPresets[presetName] ?? revealPresets.lift;
	const start = options.start ?? 'top 92%';
	const stagger = options.stagger ?? 0.08;

	gsap.set(elements, {
		...preset.from,
		willChange: 'transform, opacity',
		force3D: true,
	});

	ScrollTrigger.batch(elements, {
		start,
		once: true,
		onEnter: (batch) => {
			gsap.to(batch, {
				...preset.to,
				stagger,
				overwrite: 'auto',
				clearProps: 'willChange',
			});
		},
	});
}

async function loadGsapModules() {
	if (!gsapModulesPromise) {
		gsapModulesPromise = Promise.all([
			import('gsap'),
			import('gsap/ScrollTrigger'),
		]).then(([gsapModule, scrollTriggerModule]) => {
			const { gsap } = gsapModule;
			const { ScrollTrigger } = scrollTriggerModule;

			gsap.registerPlugin(ScrollTrigger);

			return { gsap, ScrollTrigger };
		});
	}

	return gsapModulesPromise;
}

function initProjectsPageAnimations(gsap, ScrollTrigger) {
	const page = document.querySelector('[data-projects-page]');

	if (!page) {
		return;
	}

	clearAnimationContext(page);

	if (isReducedMotion()) {
		return false;
	}

	const context = gsap.context(() => {
		const header = page.querySelector('[data-projects-header]');
		const filters = page.querySelector('[data-projects-filters]');
		const cards = Array.from(page.querySelectorAll('[data-project-card]'));
		const emptyState = page.querySelector('[data-projects-empty]');

		triggerOnce(gsap, header, {
			y: 26,
			autoAlpha: 0,
			duration: 0.58,
			ease: 'expo.out',
		});

		triggerOnce(gsap, filters, {
			x: -22,
			autoAlpha: 0,
			duration: 0.5,
			delay: 0.04,
			ease: 'power3.out',
		}, 'top 92%');

		batchReveal(gsap, ScrollTrigger, cards, 'pop', { start: 'top 92%', stagger: 0.07 });

		triggerOnce(gsap, emptyState, {
			y: 18,
			scale: 0.985,
			autoAlpha: 0,
			duration: 0.54,
			ease: 'back.out(1.1)',
		}, 'top 92%');
	}, page);

	animationContexts.set(page, context);

	return true;
}

function initHomePageAnimations(gsap, ScrollTrigger) {
	const page = document.querySelector('[data-home-page]');

	if (!page) {
		return;
	}

	clearAnimationContext(page);

	if (isReducedMotion()) {
		return false;
	}

	const context = gsap.context(() => {
		const heroText = page.querySelector('[data-home-hero-text]');
		const heroVisual = page.querySelector('[data-home-hero-visual]');
		const techItems = Array.from(page.querySelectorAll('[data-home-tech-item]'));
		const servicesHeader = page.querySelector('[data-home-services-header]');
		const serviceCards = Array.from(page.querySelectorAll('[data-home-service-card]'));
		const experienceHeader = page.querySelector('[data-home-experience-header]');
		const experienceItems = Array.from(page.querySelectorAll('[data-home-exp-item]'));
		const projectsHeader = page.querySelector('[data-home-projects-header]');
		const projectCards = Array.from(page.querySelectorAll('[data-home-project-card]'));
		const contactContent = page.querySelector('[data-home-contact-content]');
		const socialLinks = Array.from(page.querySelectorAll('[data-home-social-link]'));

		if (heroText || heroVisual) {
			const tl = gsap.timeline({ defaults: { force3D: true } });

			if (heroText) {
				tl.from(heroText, {
					y: 30,
					autoAlpha: 0,
					duration: 0.72,
					ease: 'expo.out',
				});
			}

			if (heroVisual) {
				tl.from(heroVisual, {
					y: 20,
					x: 18,
					scale: 0.97,
					autoAlpha: 0,
					duration: 0.66,
					ease: 'power3.out',
				}, '-=0.44');
			}
		}

		if (techItems.length > 0) {
			gsap.from(techItems, {
				y: 10,
				x: -8,
				autoAlpha: 0,
				duration: 0.4,
				ease: 'sine.out',
				stagger: 0.035,
				force3D: true,
				scrollTrigger: {
					trigger: techItems[0],
					start: 'top 92%',
					once: true,
				},
			});
		}

		triggerOnce(gsap, servicesHeader, {
			y: 18,
			autoAlpha: 0,
			duration: 0.52,
			ease: 'expo.out',
		});

		batchReveal(gsap, ScrollTrigger, serviceCards, 'drift', { start: 'top 92%', stagger: 0.09 });

		triggerOnce(gsap, experienceHeader, {
			x: -24,
			autoAlpha: 0,
			duration: 0.52,
			ease: 'power3.out',
		});

		batchReveal(gsap, ScrollTrigger, experienceItems, 'tilt', { start: 'top 93%', stagger: 0.08 });

		triggerOnce(gsap, projectsHeader, {
			y: 20,
			scale: 0.985,
			autoAlpha: 0,
			duration: 0.5,
			ease: 'power2.out',
		});

		batchReveal(gsap, ScrollTrigger, projectCards, 'lift', { start: 'top 92%', stagger: 0.07 });

		triggerOnce(gsap, contactContent, {
			y: 16,
			x: 14,
			autoAlpha: 0,
			duration: 0.56,
			ease: 'expo.out',
		});

		if (socialLinks.length > 0) {
			gsap.from(socialLinks, {
				y: 8,
				scale: 0.92,
				autoAlpha: 0,
				duration: 0.36,
				ease: 'back.out(1.25)',
				stagger: 0.04,
				force3D: true,
				scrollTrigger: {
					trigger: socialLinks[0],
					start: 'top 96%',
					once: true,
				},
			});
		}
	}, page);

	animationContexts.set(page, context);

	return true;
}

async function refreshAnimations() {
	if (!shouldRunAnimations()) {
		clearAnimationContext(document.querySelector('[data-projects-page]'));
		clearAnimationContext(document.querySelector('[data-home-page]'));
		return;
	}

	if (isReducedMotion()) {
		clearAnimationContext(document.querySelector('[data-projects-page]'));
		clearAnimationContext(document.querySelector('[data-home-page]'));
		return;
	}

	const { gsap, ScrollTrigger } = await loadGsapModules();
	let hasFreshContext = false;

	hasFreshContext = initProjectsPageAnimations(gsap, ScrollTrigger) || hasFreshContext;
	hasFreshContext = initHomePageAnimations(gsap, ScrollTrigger) || hasFreshContext;

	if (hasFreshContext) {
		ScrollTrigger.refresh(true);
	}
}

function scheduleUiRefresh() {
	if (animationFrameId) {
		cancelAnimationFrame(animationFrameId);
	}

	animationFrameId = requestAnimationFrame(() => {
		initLucideIcons();
		void refreshAnimations();
	});
}

function registerLivewireHooks() {
	if (livewireHooksRegistered || !window.Livewire?.hook) {
		return;
	}

	for (const hookName of ['morph.updated', 'message.processed']) {
		try {
			window.Livewire.hook(hookName, () => {
				scheduleUiRefresh();
			});
		} catch (_) {
			// Ignore unknown hooks to stay compatible with the installed Livewire version.
		}
	}

	livewireHooksRegistered = true;
}

document.addEventListener('DOMContentLoaded', scheduleUiRefresh);
document.addEventListener('livewire:init', registerLivewireHooks);
document.addEventListener('livewire:navigated', scheduleUiRefresh);
document.addEventListener('livewire:updated', scheduleUiRefresh);
registerLivewireHooks();