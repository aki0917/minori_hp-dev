gsap.registerPlugin(ScrollTrigger);

const header = document.querySelector('.l-header');
const socialLeft = document.querySelector('.social--left');
const socialRight = document.querySelector('.social--right');
const hero = document.querySelector('.l-hero');
const menuToggle = header ? header.querySelector('.l-header__toggle') : null;
const navLinks = header ? header.querySelectorAll('.l-header__nav-link') : [];
const navOverlay = header ? header.querySelector('.l-header__overlay') : null;

const focusableMenuSelector = [
  'a[href]',
  'button:not([disabled])',
  'input:not([disabled])',
  'select:not([disabled])',
  'textarea:not([disabled])',
  '[tabindex]:not([tabindex="-1"])'
].join(', ');

let lastFocusedElement = null;

const isElementVisible = (element) => {
  if (!element) return false;
  if (element.hasAttribute('hidden')) return false;
  if (element.getAttribute('aria-hidden') === 'true') return false;
  const style = window.getComputedStyle(element);
  return style.display !== 'none' && style.visibility !== 'hidden';
};

const getFocusableMenuElements = () => {
  if (!header) return [];
  return Array.from(header.querySelectorAll(focusableMenuSelector)).filter((element) => isElementVisible(element));
};

const handleFocusTrap = (event) => {
  if (event.key !== 'Tab' || !header || !header.classList.contains('is-open')) return;

  const focusableElements = getFocusableMenuElements();
  if (!focusableElements.length) return;

  const firstElement = focusableElements[0];
  const lastElement = focusableElements[focusableElements.length - 1];

  if (event.shiftKey) {
    if (document.activeElement === firstElement) {
      event.preventDefault();
      lastElement.focus();
    }
  } else if (document.activeElement === lastElement) {
    event.preventDefault();
    firstElement.focus();
  }
};

const closeMenu = () => {
  if (!header || !menuToggle) return;
  
  const nav = header.querySelector('.l-header__nav');
  const overlay = header.querySelector('.l-header__overlay');
  
  const isTabletOrLarger = window.matchMedia('(min-width: 769px)').matches;
  
  const navSocial = nav ? nav.querySelector('.l-header__nav-social') : null;
  
  const tl = gsap.timeline({
    onComplete: () => {
      if (nav) {
        if (isTabletOrLarger) {
          gsap.set(nav, {
            clearProps: 'all'
          });
        } else {
          gsap.set(nav, {
            visibility: 'hidden',
            pointerEvents: 'none'
          });
        }
      }
      if (overlay) {
        if (isTabletOrLarger) {
          gsap.set(overlay, {
            clearProps: 'all'
          });
        } else {
          gsap.set(overlay, {
            visibility: 'hidden',
            pointerEvents: 'none'
          });
        }
      }
      
      // SNSリンクもリセット
      if (navSocial) {
        gsap.set(navSocial, {
          clearProps: 'all'
        });
      }
      
      header.classList.remove('is-open');
      document.body.classList.remove('is-menu-open');
      menuToggle.setAttribute('aria-expanded', 'false');
      menuToggle.setAttribute('aria-label', 'メニューを開く');
      if (navOverlay) {
        navOverlay.setAttribute('aria-hidden', 'true');
      }
      
      // GSAPのtransformを復元（ScrollTriggerが管理している状態に戻す）
      if (hero) {
        ScrollTrigger.refresh();
      }
    }
  });
  
  // SNSリンクをフェードアウト（メニューより先に）
  if (navSocial) {
    tl.to(navSocial, {
      opacity: 0,
      y: 10,
      duration: 0.25,
      ease: 'power2.in'
    }, 0);
  }
  
  // ナビゲーションを右にスライドアウト
  if (nav) {
    tl.to(nav, {
      x: '100%',
      opacity: 0,
      duration: 0.35,
      ease: 'power2.in'
    }, 0.05);
  }
  
  // オーバーレイをフェードアウト
  if (overlay) {
    tl.to(overlay, {
      opacity: 0,
      duration: 0.3,
      ease: 'power2.in'
    }, 0);
  }
  
  document.removeEventListener('keydown', handleFocusTrap);

  if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
    if (isElementVisible(lastFocusedElement)) {
      lastFocusedElement.focus();
    }
  }
  lastFocusedElement = null;
};

const openMenu = () => {
  if (!header || !menuToggle) return;
  
  // GSAPのtransformを一時的に無効化（メニューの位置ズレを防ぐため）
  // 親要素のtransformが子要素のposition: fixedに影響するのを防ぐ
  gsap.set(header, { 
    clearProps: "transform",
    force3D: false
  });
  
  const nav = header.querySelector('.l-header__nav');
  const overlay = header.querySelector('.l-header__overlay');
  
  // クラスを追加（スタイルの初期状態を設定）
  header.classList.add('is-open');
  document.body.classList.add('is-menu-open');
  menuToggle.setAttribute('aria-expanded', 'true');
  menuToggle.setAttribute('aria-label', 'メニューを閉じる');
  if (navOverlay) {
    navOverlay.setAttribute('aria-hidden', 'false');
  }
  
  // 初期状態を設定
  if (nav) {
    gsap.set(nav, {
      x: '100%',
      opacity: 0,
      backgroundColor: 'transparent',
      visibility: 'visible',
      pointerEvents: 'auto'
    });
  }
  
  if (overlay) {
    gsap.set(overlay, {
      opacity: 0,
      visibility: 'visible',
      pointerEvents: 'auto'
    });
  }
  
  // メニュー内のSNSリンクの初期状態を設定
  const navSocial = nav ? nav.querySelector('.l-header__nav-social') : null;
  if (navSocial) {
    gsap.set(navSocial, {
      opacity: 0,
      y: 20
    });
  }
  
  // GSAPアニメーション：メニューを開く
  const tl = gsap.timeline();
  
  // オーバーレイをフェードイン
  if (overlay) {
    tl.to(overlay, {
      opacity: 1,
      duration: 0.3,
      ease: 'power2.out'
    }, 0);
  }
  
  // ナビゲーションを右からスライドイン + 背景を白に
  if (nav) {
    tl.to(nav, {
      x: '0%',
      opacity: 1,
      backgroundColor: '#ffffff',
      duration: 0.35,
      ease: 'power2.out'
    }, 0.05);
  }
  
  // SNSリンクをフェードイン + スライドイン（メニューの後に表示）
  if (navSocial) {
    tl.to(navSocial, {
      opacity: 1,
      y: 0,
      duration: 0.5,
      ease: 'power2.out'
    }, 0.25);
  }
  
  
  lastFocusedElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;
  document.addEventListener('keydown', handleFocusTrap);

  const focusableElements = getFocusableMenuElements();
  const firstLink = focusableElements.find((element) => element !== menuToggle && element.tagName.toLowerCase() === 'a');
  const elementToFocus = firstLink || menuToggle;

  if (elementToFocus) {
    // アニメーションが少し進んでからフォーカス
    requestAnimationFrame(() => {
      setTimeout(() => {
        elementToFocus.focus();
      }, 200);
    });
  }
};

if (menuToggle) {
  menuToggle.addEventListener('click', () => {
    if (header.classList.contains('is-open')) {
      closeMenu();
    } else {
      openMenu();
    }
  });
}

if (navLinks.length) {
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      if (header.classList.contains('is-open')) {
        closeMenu();
      }
    });
  });
}

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape' && header && header.classList.contains('is-open')) {
    closeMenu();
  }
});

if (navOverlay) {
  navOverlay.addEventListener('click', closeMenu);
}

const desktopMediaQuery = window.matchMedia('(min-width: 769px)');
const handleMediaQueryChange = (event) => {
  if (event.matches) {
    // タブレットサイズ以上になった時
    const nav = header ? header.querySelector('.l-header__nav') : null;
    const overlay = header ? header.querySelector('.l-header__overlay') : null;
    
    // メニューが開いている場合は閉じる
    if (header && header.classList.contains('is-open')) {
      // クラスと属性をリセット
      header.classList.remove('is-open');
      document.body.classList.remove('is-menu-open');
      if (menuToggle) {
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-label', 'メニューを開く');
      }
      if (navOverlay) {
        navOverlay.setAttribute('aria-hidden', 'true');
      }
      
      document.removeEventListener('keydown', handleFocusTrap);
      lastFocusedElement = null;
    }
    
    // メニューの開閉状態に関係なく、GSAPのプロパティをクリアしてCSSの通常表示に戻す
    // （SPでメニューを開閉した後にタブレットサイズに変更した場合でも正しく表示されるように）
    if (nav) {
      gsap.set(nav, {
        clearProps: 'all' // すべてのGSAPプロパティをクリア
      });
    }
    
    if (overlay) {
      gsap.set(overlay, {
        clearProps: 'all' // すべてのGSAPプロパティをクリア
      });
    }
  }
};

if (desktopMediaQuery.addEventListener) {
  desktopMediaQuery.addEventListener('change', handleMediaQueryChange);
} else if (desktopMediaQuery.addListener) {
  desktopMediaQuery.addListener(handleMediaQueryChange);
}

// ヒーローセクションの高さを取得
const heroHeight = hero ? hero.offsetHeight : 0;

// ヒーローセクションが存在する場合のみ、ヘッダーを非表示にしてScrollTriggerで制御
if (hero) {
  // ヒーローコンテンツの要素を取得
  const heroContent = hero.querySelector('.l-hero__content');
  const heroCopy = hero.querySelector('.l-hero__copy');
  const heroBg = hero.querySelector('.l-hero-bg');
  
  // ヒーローコンテンツの初期状態を設定
  if (heroContent) {
    gsap.set(heroContent, {
      opacity: 0
    });
  }
  
  if (heroCopy) {
    gsap.set(heroCopy, {
      opacity: 0,
      y: 30 // 下からスライドイン
    });
  }
  
  // CSSフォールバックアニメーション（delay:300ms + duration:1200ms + buffer:100ms = 1600ms）との
  // 競合チェック：GSAPが間に合った場合のみCSSアニメーションをキャンセルして引き継ぐ
  // 遅延した場合はCSSアニメーションがLCPを確保済みのため、画像アニメーションはスキップ
  const HERO_ANIM_COMPLETE_MS = 1600;
  const gsapLoadedEarly = performance.now() < HERO_ANIM_COMPLETE_MS;

  // モバイル: LCP改善のためヒーロー画像アニメーションをスキップ（即時表示）
  const isMobileHero = window.matchMedia('(max-width: 768px)').matches;

  if (heroBg && !isMobileHero) {
    const heroImage = heroBg.querySelector('img');
    if (heroImage && gsapLoadedEarly) {
      heroImage.style.animation = 'none'; // CSSフォールバックをキャンセルしGSAPが引き継ぐ
      gsap.set(heroImage, {
        scale: 1.1,
        opacity: 0
      });
    }
  }

  // ページ読み込み時にヒーローアニメーションを実行
  const heroTl = gsap.timeline({ delay: 0.3 });

  if (heroBg && gsapLoadedEarly && !isMobileHero) {
    const heroImage = heroBg.querySelector('img');
    if (heroImage) {
      heroTl.to(heroImage, {
        opacity: 1,
        scale: 1,
        duration: 1.2,
        ease: 'power2.out'
      });
    }
  }

  if (heroContent) {
    heroTl.to(heroContent, {
      opacity: 1,
      duration: 0.6,
      ease: 'power2.out'
    }, 0.2);
  }

  if (heroCopy) {
    heroTl.to(heroCopy, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      ease: 'power3.out'
    }, 0.4);
  }
  
  // 初期状態：ヘッダーとsocialを非表示に設定
  gsap.set(header, {
    opacity: 0,
    y: -20,
    pointerEvents: 'none'
  });

  gsap.set(socialLeft, {
    opacity: 0,
    x: -60, // 左に隠す
    yPercent: -50, // CSSのtranslateY(-50%)を維持
    pointerEvents: 'none'
  });

  gsap.set(socialRight, {
    opacity: 0,
    x: 60, // 右に隠す
    yPercent: -50, // CSSのtranslateY(-50%)を維持
    pointerEvents: 'none'
  });

  // ScrollTriggerでヒーローセクションが見えなくなったら表示
  ScrollTrigger.create({
    trigger: hero,
    start: 'bottom top', // ヒーローの下端がビューポートの上端に達したとき
    onEnter: () => {
      // ヘッダーとsocialを表示（フェードイン + アニメーション）
      gsap.to(header, {
        opacity: 1,
        y: 0,
        duration: 0.6,
        ease: 'power2.out',
        pointerEvents: 'auto'
      });
      
      gsap.to(socialLeft, {
        opacity: 1,
        x: 0, // 元の位置に戻す
        yPercent: -50, // CSSのtranslateY(-50%)を維持
        duration: 0.6,
        ease: 'power2.out',
        pointerEvents: 'auto'
      });
      
      gsap.to(socialRight, {
        opacity: 1,
        x: 0, // 元の位置に戻す
        yPercent: -50, // CSSのtranslateY(-50%)を維持
        duration: 0.6,
        ease: 'power2.out',
        pointerEvents: 'auto'
      });
    },
    onLeaveBack: () => {
      closeMenu();
      // 上にスクロールしてヒーローに戻ったら非表示
      gsap.to(header, {
        opacity: 0,
        y: -20,
        duration: 0.4,
        ease: 'power2.in',
        pointerEvents: 'none'
      });
      
      gsap.to(socialLeft, {
        opacity: 0,
        x: -60,
        yPercent: -50, // CSSのtranslateY(-50%)を維持
        duration: 0.4,
        ease: 'power2.in',
        pointerEvents: 'none'
      });
      
      gsap.to(socialRight, {
        opacity: 0,
        x: 60,
        yPercent: -50, // CSSのtranslateY(-50%)を維持
        duration: 0.4,
        ease: 'power2.in',
        pointerEvents: 'none'
      });
    }
  });
} else {
  // ヒーローセクションが存在しない場合（about.htmlなど）、ヘッダーを常に表示
  if (header) {
    gsap.set(header, {
      opacity: 1,
      y: 0,
      pointerEvents: 'auto'
    });
  }
  
  if (socialLeft) {
    gsap.set(socialLeft, {
      opacity: 1,
      x: 0,
      yPercent: -50,
      pointerEvents: 'auto'
    });
  }
  
  if (socialRight) {
    gsap.set(socialRight, {
      opacity: 1,
      x: 0,
      yPercent: -50,
      pointerEvents: 'auto'
    });
  }
}

// Services Modal
const servicesModal = document.getElementById('servicesModal');
const modalOverlay = document.querySelector('.p-services-modal__overlay');
const modalClose = document.querySelector('.p-services-modal__close');
const modalTitle = document.getElementById('modalTitle');
const modalImage = document.getElementById('modalImage');
const modalBody = document.getElementById('modalBody');
const petalContents = document.querySelectorAll('.p-services__petal-content');

// モーダルを開く
function openModal(title, image, body) {
  if (!servicesModal || !modalTitle || !modalBody) return;
  
  modalTitle.textContent = title;
  modalBody.innerHTML = body;
  
  const imageWrapper = document.querySelector('.p-services-modal__image-wrapper');
  const hasImage = Boolean(image && image.trim() !== '');

  if (servicesModal) {
    servicesModal.classList.toggle('p-services-modal--has-image', hasImage);
  }

  if (modalImage) {
    if (hasImage) {
      modalImage.src = image;
      modalImage.alt = title;
      modalImage.hidden = false;
    } else {
      modalImage.removeAttribute('src');
      modalImage.alt = '';
      modalImage.hidden = true;
    }
  }

  if (imageWrapper) {
    imageWrapper.style.display = hasImage ? 'block' : 'none';
  }
  
  // モーダルを表示
  servicesModal.classList.add('is-active');
  document.body.style.overflow = 'hidden'; // 背景のスクロールを無効化
  
  // GSAPアニメーション：ふわっと表示
  const overlay = document.querySelector('.p-services-modal__overlay');
  const content = document.querySelector('.p-services-modal__content');
  
  // 初期状態を設定
  gsap.set(servicesModal, { opacity: 0 });
  gsap.set(overlay, { opacity: 0, backdropFilter: 'blur(0px)' });
  gsap.set(content, { scale: 0.8, y: 30, opacity: 0 });
  
  // アニメーション実行
  const tl = gsap.timeline();
  tl.to(servicesModal, {
    opacity: 1,
    duration: 0.3,
    ease: 'power2.out'
  })
  .to(overlay, {
    opacity: 1,
    backdropFilter: 'blur(4px)',
    duration: 0.4,
    ease: 'power2.out'
  }, 0)
  .to(content, {
    scale: 1,
    y: 0,
    opacity: 1,
    duration: 0.5,
    ease: 'back.out(1.4)' // バウンス効果
  }, 0.1);
}

// モーダルを閉じる
function closeModal() {
  const overlay = document.querySelector('.p-services-modal__overlay');
  const content = document.querySelector('.p-services-modal__content');
  
  // GSAPアニメーション：ふわっと閉じる
  const tl = gsap.timeline({
    onComplete: () => {
      servicesModal.classList.remove('is-active');
      servicesModal.classList.remove('p-services-modal--has-image');
      document.body.style.overflow = ''; // 背景のスクロールを有効化

      if (modalImage) {
        modalImage.removeAttribute('src');
        modalImage.alt = '';
        modalImage.hidden = true;
      }

      const imageWrapper = document.querySelector('.p-services-modal__image-wrapper');
      if (imageWrapper) {
        imageWrapper.style.display = 'none';
      }
    }
  });
  
  tl.to(content, {
    scale: 0.9,
    y: 20,
    opacity: 0,
    duration: 0.3,
    ease: 'power2.in'
  })
  .to(overlay, {
    opacity: 0,
    backdropFilter: 'blur(0px)',
    duration: 0.3,
    ease: 'power2.in'
  }, 0)
  .to(servicesModal, {
    opacity: 0,
    duration: 0.2,
    ease: 'power2.in'
  }, 0.1);
}

// 各花びらにクリックイベントを追加
petalContents.forEach((content) => {
  content.addEventListener('click', (e) => {
    e.stopPropagation();
    const title = content.getAttribute('data-modal-title') || '';
    const image = content.getAttribute('data-modal-image') || '';
    const body = content.getAttribute('data-modal-body') || '';
    openModal(title, image, body);
  });
});

// モーダルを閉じるイベント
if (modalOverlay) {
  modalOverlay.addEventListener('click', (e) => {
    // オーバーレイのみクリックで閉じる（モーダルコンテンツ内は閉じない）
    if (e.target === modalOverlay) {
      closeModal();
    }
  });
}

if (modalClose) {
  modalClose.addEventListener('click', (e) => {
    e.stopPropagation();
    closeModal();
  });
}

// モーダルコンテンツ内のクリックで閉じないようにする
const modalContent = document.querySelector('.p-services-modal__content');
if (modalContent) {
  modalContent.addEventListener('click', (e) => {
    e.stopPropagation();
  });
}

// ESCキーでモーダルを閉じる
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && servicesModal.classList.contains('is-active')) {
    closeModal();
  }
});

// よくある質問（FAQ）のアコーディオン機能
const faqItems = document.querySelectorAll('.p-info__faq-item');
faqItems.forEach((item) => {
  const question = item.querySelector('.p-info__faq-question');
  const answer = item.querySelector('.p-info__faq-answer');
  const icon = item.querySelector('.p-info__faq-icon');
  
  if (question && answer) {
    question.addEventListener('click', () => {
      const isExpanded = question.getAttribute('aria-expanded') === 'true';
      
      // 他のFAQを閉じる
      faqItems.forEach((otherItem) => {
        if (otherItem !== item) {
          const otherQuestion = otherItem.querySelector('.p-info__faq-question');
          const otherAnswer = otherItem.querySelector('.p-info__faq-answer');
          const otherIcon = otherItem.querySelector('.p-info__faq-icon');
          if (otherQuestion && otherAnswer) {
            otherQuestion.setAttribute('aria-expanded', 'false');
            otherItem.setAttribute('aria-expanded', 'false');
            otherAnswer.style.maxHeight = '0';
            otherAnswer.style.padding = '0 0';
            if (otherIcon) {
              otherIcon.textContent = '+';
            }
          }
        }
      });
      
      // 現在のFAQを開閉
      if (isExpanded) {
        question.setAttribute('aria-expanded', 'false');
        item.setAttribute('aria-expanded', 'false');
        answer.style.maxHeight = '0';
        answer.style.padding = '0 0';
        if (icon) {
          icon.textContent = '+';
        }
      } else {
        question.setAttribute('aria-expanded', 'true');
        item.setAttribute('aria-expanded', 'true');
        const answerHeight = answer.scrollHeight;
        answer.style.maxHeight = `${answerHeight}px`;
        answer.style.padding = '0 0 24px';
        
        // タブレット以上では28px
        if (window.innerWidth >= 768) {
          answer.style.padding = '0 0 28px';
        }
        
        if (icon) {
          icon.textContent = '−';
        }
      }
    });
  }
});

// インフォメーションセクションのスライダー
const infoSlider = document.querySelector('.p-info__slider');
if (infoSlider) {
  new Swiper('.p-info__slider', {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: '.p-info__button-next',
      prevEl: '.p-info__button-prev',
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
        spaceBetween: 32,
      },
      992: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
    },
  });
}

// 沿革セクションのアニメーション
const historySection = document.querySelector('.p-about-history');
if (historySection) {
  const historyList = historySection.querySelector('.p-about-history__list');
  const historyItems = historySection.querySelectorAll('.p-about-history__item');
  
  if (historyList && historyItems.length > 0) {
    // プログレスバーの要素を作成
    const progressBarElement = document.createElement('div');
    progressBarElement.className = 'p-about-history__progress-bar';
    historyList.style.position = 'relative';
    historyList.insertBefore(progressBarElement, historyList.firstChild);
    
    // プログレスバーの位置を更新する関数（常に中央）
    const updateProgressBarPosition = () => {
      progressBarElement.style.left = '50%';
      progressBarElement.style.transform = 'translateX(-50%)';
    };
    
    // 初期位置を設定
    updateProgressBarPosition();
    
    // リサイズ時に位置を更新
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        updateProgressBarPosition();
      }, 250);
    });
    
    // プログレスバーの高さを計算
    const getProgressBarHeight = () => {
      return historyList.scrollHeight;
    };
    
    // 初期状態：プログレスバーを非表示
    gsap.set(progressBarElement, {
      height: 0
    });
    
    // 各項目の初期状態を設定
    historyItems.forEach((item, index) => {
      const textWrapper = item.querySelector('.p-about-history__text-wrapper');
      const year = item.querySelector('.p-about-history__year');
      const text = item.querySelector('.p-about-history__text');
      const image = item.querySelector('.p-about-history__image');
      
      if (!year || !text) return;
      
      // 最後の項目は初期状態で表示
      const isLastItem = index === historyItems.length - 1;
      
      if (isLastItem) {
        // 最後の項目は表示状態
        item.classList.remove('p-about-history__item--hidden');
        gsap.set([year, text], {
          opacity: 1,
          x: 0
        });
        if (image) {
          gsap.set(image, {
            opacity: 1,
            scale: 1
          });
        }
      } else {
        // それ以外の項目は非表示
        const isMobile = window.innerWidth < 769;
        const isOdd = index % 2 === 0;
        
        // テキストの初期状態
        if (isMobile) {
          // モバイル：左からスライド
          gsap.set([year, text], {
            opacity: 0,
            x: -30
          });
        } else {
          // タブレット以上：交互にスライド
          if (isOdd) {
            // 左側（奇数）
            gsap.set([year, text], {
              opacity: 0,
              x: -30
            });
          } else {
            // 右側（偶数）
            gsap.set([year, text], {
              opacity: 0,
              x: 30
            });
          }
        }
        
        // 画像の初期状態
        if (image) {
          gsap.set(image, {
            opacity: 0,
            scale: 0.8
          });
        }
        
        // ドットの初期状態（itemにクラスを追加してCSSで制御）
        item.classList.add('p-about-history__item--hidden');
      }
    });
    
    // プログレスバーの高さを取得
    const progressBarHeight = getProgressBarHeight();
    
    // プログレスバーをスクロールに連動させるアニメーション
    gsap.to(progressBarElement, {
      height: progressBarHeight,
      ease: 'none',
      scrollTrigger: {
        trigger: historySection,
        start: 'top 80%', // セクションが表示され始めた時点で開始
        end: 'bottom bottom', // セクションの下端がビューポートの下端に達するまで
        scrub: true, // スクロールに連動
        onUpdate: (self) => {
          // スクロール進捗に応じて各項目を表示
          const progress = self.progress;
          const totalItems = historyItems.length;
          
          historyItems.forEach((item, index) => {
            const year = item.querySelector('.p-about-history__year');
            const text = item.querySelector('.p-about-history__text');
            const image = item.querySelector('.p-about-history__image');
            
            if (!year || !text) return;
            
            // 各項目の表示タイミングを計算（後半の項目を早く表示するように調整）
            // 前半70%の進捗で最初の70%の項目を表示、残り30%の進捗で残りの項目を表示
            const earlyItemsCount = Math.ceil(totalItems * 0.7);
            let itemStartProgress, itemEndProgress;
            
            if (index < earlyItemsCount) {
              // 前半の項目：0-70%の進捗で表示
              const earlyProgress = 0.7;
              itemStartProgress = (index / earlyItemsCount) * earlyProgress;
              itemEndProgress = ((index + 1) / earlyItemsCount) * earlyProgress;
            } else {
              // 後半の項目：70-100%の進捗で表示
              const lateProgress = 0.3;
              const lateIndex = index - earlyItemsCount;
              const lateItemsCount = totalItems - earlyItemsCount;
              itemStartProgress = 0.7 + (lateIndex / lateItemsCount) * lateProgress;
              itemEndProgress = 0.7 + ((lateIndex + 1) / lateItemsCount) * lateProgress;
            }
            
            // 項目が表示範囲に入ったらアニメーション
            if (progress >= itemStartProgress) {
              const itemLocalProgress = Math.min(
                (progress - itemStartProgress) / (itemEndProgress - itemStartProgress),
                1
              );
              
              // ドットを表示/非表示（より早く表示）
              if (itemLocalProgress > 0.05) {
                item.classList.remove('p-about-history__item--hidden');
              } else {
                item.classList.add('p-about-history__item--hidden');
              }
              
              // テキストをフェードイン＋スライド（より早く表示）
              const opacity = Math.min(itemLocalProgress * 2.5, 1);
              const xOffset = (1 - itemLocalProgress) * 30;
              
              const isMobile = window.innerWidth < 769;
              const isOdd = index % 2 === 0;
              
              if (isMobile) {
                gsap.set([year, text], {
                  opacity: opacity,
                  x: -xOffset
                });
              } else {
                if (isOdd) {
                  gsap.set([year, text], {
                    opacity: opacity,
                    x: -xOffset
                  });
                } else {
                  gsap.set([year, text], {
                    opacity: opacity,
                    x: xOffset
                  });
                }
              }
              
              // 画像をフェードイン＋スケール（より早く表示）
              if (image) {
                const imageOpacity = Math.min(itemLocalProgress * 2, 1);
                const imageScale = 0.8 + (itemLocalProgress * 0.2);
                gsap.set(image, {
                  opacity: imageOpacity,
                  scale: imageScale
                });
              }
            } else {
              // 項目が表示範囲外の場合は非表示
              item.classList.add('p-about-history__item--hidden');
              gsap.set([year, text], {
                opacity: 0
              });
              if (image) {
                gsap.set(image, {
                  opacity: 0,
                  scale: 0.8
                });
              }
            }
          });
        },
      }
    });
  }
}

// 企業理念セクションのアニメーション
const aboutSection = document.querySelector('.p-about');
if (aboutSection) {
  const aboutItems = aboutSection.querySelectorAll('.p-about__item');
  const aboutImages = aboutSection.querySelectorAll('.p-about__image');
  const aboutOverlay = aboutSection.querySelector('.p-about__overlay');
  const aboutTitle = aboutSection.querySelector('.p-about__title');
  const aboutText = aboutSection.querySelector('.p-about__text');
  
  if (aboutItems.length > 0) {
    // 各画像の初期状態を設定
    aboutItems.forEach((item, index) => {
      const image = item.querySelector('.p-about__image');
      
      // マスクアニメーション用の初期状態
      gsap.set(image, {
        clipPath: 'inset(100% 0 0 0)', // 上から下にマスク（100% = 完全に隠れる）
        opacity: 0,
        y: 50 // 下からスライドイン用
      });
      
      // アイテム全体も初期状態を設定
      gsap.set(item, {
        opacity: 0
      });
    });
    
    // オーバーレイの初期状態を設定
    if (aboutOverlay) {
      // sp時かどうかを判定（769px未満）
      const isMobile = window.innerWidth < 769;
      
      if (isMobile) {
        // sp時: 中央配置
        gsap.set(aboutOverlay, {
          opacity: 0,
          scale: 0.8,
          xPercent: -50,
          yPercent: -50,
          y: 30 // 初期状態で少し下に配置
        });
      } else {
        // tab以上: 通常のアニメーション（完全中央）
        gsap.set(aboutOverlay, {
          opacity: 0,
          scale: 0.8,
          xPercent: -50,
          yPercent: -50,
          y: 30
        });
      }
      
      if (aboutTitle) {
        gsap.set(aboutTitle, {
          opacity: 0,
          y: 20
        });
      }
      
      if (aboutText) {
        gsap.set(aboutText, {
          opacity: 0,
          y: 20
        });
      }
    }
    
    // ScrollTriggerでアニメーションを発動
    ScrollTrigger.create({
      trigger: aboutSection,
      start: 'top 80%', // セクションが80%見えたら開始
      once: true, // 一度だけ実行
      onEnter: () => {
        // タイムラインを作成
        const tl = gsap.timeline();
        
        // 各画像を順番にアニメーション（0.1秒間隔）
        aboutItems.forEach((item, index) => {
          const image = item.querySelector('.p-about__image');
          
          // マスクアニメーション + フェードイン + スライドイン
          tl.to(item, {
            opacity: 1,
            duration: 0.3,
            ease: 'power2.out'
          }, index * 0.1)
          .to(image, {
            clipPath: 'inset(0% 0 0 0)', // マスクを解除（完全に表示）
            opacity: 1,
            y: 0, // 元の位置に戻す
            duration: 0.8,
            ease: 'power2.out'
          }, index * 0.1);
        });
        
        // オーバーレイテキストのアニメーション（画像のアニメーションの後半から開始）
        if (aboutOverlay) {
          const overlayDelay = (aboutItems.length - 1) * 0.1 + 0.3;
          const isMobile = window.innerWidth < 769;
          
          if (isMobile) {
            // sp時: 中央配置
            tl.to(aboutOverlay, {
              opacity: 1,
              scale: 1,
              xPercent: -50,
              yPercent: -50,
              y: 0, // 初期状態のy: 30から0に戻す
              duration: 0.6,
              ease: 'back.out(1.2)' // バウンス効果
            }, overlayDelay)
            .to(aboutTitle, {
              opacity: 1,
              y: 0,
              duration: 0.4,
              ease: 'power2.out'
            }, overlayDelay + 0.1);
          } else {
            // tab以上: 通常のアニメーション（完全中央）
            tl.to(aboutOverlay, {
              opacity: 1,
              scale: 1,
              xPercent: -50,
              yPercent: -50,
              y: 0, // 初期状態のy: 30から0に戻す
              duration: 0.6,
              ease: 'back.out(1.2)' // バウンス効果
            }, overlayDelay)
            .to(aboutTitle, {
              opacity: 1,
              y: 0,
              duration: 0.4,
              ease: 'power2.out'
            }, overlayDelay + 0.1);
          }
          
          // 企業理念テキストの特別なアニメーション（グラデーション＋文字アニメーション）
          if (aboutText) {
            const originalText = aboutText.textContent.trim();
            const computedStyle = window.getComputedStyle(aboutText);
            const letterSpacing = computedStyle.letterSpacing;
            
            aboutText.textContent = '';
            aboutText.style.opacity = '1';
            aboutText.style.display = 'block';
            
            const chars = originalText.split('');
            let charIndex = 0; // アニメーション用のインデックス（スペースを除く）
            
            chars.forEach((char, index) => {
              // 改行は無視
              if (char === '\n' || char === '\r') {
                return;
              }
              
              const span = document.createElement('span');
              
              // スペースの処理
              if (char === ' ') {
                span.textContent = ' ';
                span.style.display = 'inline';
                span.style.letterSpacing = letterSpacing;
                aboutText.appendChild(span);
              } else {
                span.textContent = char;
                span.style.display = 'inline-block';
                span.style.background = 'linear-gradient(135deg, #2E7D32, #4CAF50)';
                span.style.WebkitBackgroundClip = 'text';
                span.style.WebkitTextFillColor = 'transparent';
                span.style.backgroundClip = 'text';
                span.style.opacity = '0';
                span.style.transform = 'translateY(20px) scale(0.8)';
                span.style.verticalAlign = 'baseline';
                span.style.lineHeight = 'inherit';
                span.style.letterSpacing = letterSpacing;
                span.style.marginRight = '0';
                
                aboutText.appendChild(span);
                
                // アニメーション実行
                gsap.to(span, {
                  opacity: 1,
                  y: 0,
                  scale: 1,
                  duration: 0.5,
                  delay: (overlayDelay + 0.2) + (charIndex * 0.04),
                  ease: 'back.out(1.6)'
                });
                
                charIndex++;
              }
            });
          }
        }
      },
      // 上にスクロールして戻ったときのアニメーション（オプション）
      onLeaveBack: () => {
        // アニメーションをリセット（必要に応じて）
      }
    });
  }
}

// 超スローフード宣言セクションのアニメーション
const aboutMessageSection = document.querySelector('.p-about-message');
if (aboutMessageSection) {
  const messageTexts = aboutMessageSection.querySelectorAll('.p-about-message__text');
  const messageTitle = aboutMessageSection.querySelector('.p-about-message__title');
  
  if (messageTexts.length > 0) {
    // タイトルの初期状態
    if (messageTitle) {
      gsap.set(messageTitle, {
        opacity: 0,
        y: 30
      });
    }
    
    // 各段落の初期状態
    messageTexts.forEach((text, index) => {
      gsap.set(text, {
        opacity: 0,
        y: 40
      });
    });
    
    // ScrollTriggerでアニメーションを発動
    ScrollTrigger.create({
      trigger: aboutMessageSection,
      start: 'top 75%', // セクションが75%見えたら開始
      onEnter: () => {
        const tl = gsap.timeline();
        
        // タイトルをアニメーション
        if (messageTitle) {
          tl.to(messageTitle, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out'
          });
        }
        
        // 各段落を順番にアニメーション
        messageTexts.forEach((text, index) => {
          tl.to(text, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power2.out'
          }, 0.3 + (index * 0.2)); // タイトルの後、0.2秒間隔で表示
        });
      }
    });
  }
}

// E-E-A-Tセクションのアニメーション（運営者紹介・強み・価値）
const aboutEaatSection = document.querySelector('.p-about-eaat');
if (aboutEaatSection) {
  // パララックス背景画像のアニメーション
  const eaatBgImage = aboutEaatSection.querySelector('.p-about-eaat__bg-image');
  if (eaatBgImage) {
    gsap.to(eaatBgImage, {
      yPercent: 30, // 下に30%移動（スクロールに応じて）
      ease: 'none',
      scrollTrigger: {
        trigger: aboutEaatSection,
        start: 'top bottom',
        end: 'bottom top',
        scrub: true // スクロールに連動
      }
    });
  }

  const eaatItems = aboutEaatSection.querySelectorAll('.p-about-eaat__item');
  
  if (eaatItems.length > 0) {
    // 各アイテム（カード）の初期状態を設定
    eaatItems.forEach((item, itemIndex) => {
      const subtitle = item.querySelector('.p-about-eaat__subtitle');
      const texts = item.querySelectorAll('.p-about-eaat__text');
      
      // カード全体の初期状態
      gsap.set(item, {
        opacity: 0,
        y: 50,
        scale: 0.95
      });
      
      // タイトルの初期状態
      if (subtitle) {
        gsap.set(subtitle, {
          opacity: 0,
          y: 30
        });
      }
      
      // 各テキストの初期状態
      texts.forEach((text, textIndex) => {
        gsap.set(text, {
          opacity: 0,
          y: 30
        });
      });
    });
    
    // ScrollTriggerでアニメーションを発動
    ScrollTrigger.create({
      trigger: aboutEaatSection,
      start: 'top 80%', // セクションが80%見えたら開始
      once: true, // 一度だけ実行
      onEnter: () => {
        const tl = gsap.timeline();
        
        // 各アイテムを順番にアニメーション
        eaatItems.forEach((item, itemIndex) => {
          const subtitle = item.querySelector('.p-about-eaat__subtitle');
          const texts = item.querySelectorAll('.p-about-eaat__text');
          
          // カード全体のアニメーション（0.2秒間隔で順番に表示）
          const itemDelay = itemIndex * 0.2;
          
          tl.to(item, {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.7,
            ease: 'power2.out'
          }, itemDelay);
          
          // タイトルのアニメーション（カードのアニメーションと同時開始）
          if (subtitle) {
            tl.to(subtitle, {
              opacity: 1,
              y: 0,
              duration: 0.6,
              ease: 'power2.out'
            }, itemDelay + 0.1);
          }
          
          // 各テキストを順番にアニメーション（タイトルの後、0.15秒間隔）
          texts.forEach((text, textIndex) => {
            tl.to(text, {
              opacity: 1,
              y: 0,
              duration: 0.6,
              ease: 'power2.out'
            }, itemDelay + 0.2 + (textIndex * 0.15));
          });
        });
      }
    });
  }
}

// 店舗一覧セクションのアニメーション
const shopSection = document.querySelector('.p-shop');
if (shopSection) {
  const shopTitle = shopSection.querySelector('.p-shop__title');
  const shopDescription = shopSection.querySelector('.p-shop__description');
  const shopItems = shopSection.querySelectorAll('.p-shop__item');
  
  if (shopItems.length > 0) {
    // タイトルと説明文の初期状態
    if (shopTitle) {
      gsap.set(shopTitle, {
        opacity: 0,
        y: 30
      });
    }
    
    if (shopDescription) {
      gsap.set(shopDescription, {
        opacity: 0,
        y: 20
      });
    }
    
    // 各店舗カードの初期状態
    shopItems.forEach((item, index) => {
      const card = item.querySelector('.p-shop__card');
      const image = item.querySelector('.p-shop__image');
      const content = item.querySelector('.p-shop__content');
      
      if (card) {
        gsap.set(card, {
          opacity: 0,
          y: 50,
          scale: 0.95
        });
      }
      
      if (image) {
        gsap.set(image, {
          scale: 1.1 // 少し拡大した状態から開始
        });
      }
      
      if (content) {
        gsap.set(content, {
          opacity: 0,
          y: 20
        });
      }
    });
    
    // ScrollTriggerでアニメーションを発動
    ScrollTrigger.create({
      trigger: shopSection,
      start: 'top 80%', // セクションが80%見えたら開始
      onEnter: () => {
        const tl = gsap.timeline();
        
        // タイトルをアニメーション
        if (shopTitle) {
          tl.to(shopTitle, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out'
          });
        }
        
        // 説明文をアニメーション
        if (shopDescription) {
          tl.to(shopDescription, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out'
          }, 0.2);
        }
        
        // 各店舗カードを順番にアニメーション（0.1秒間隔）
        shopItems.forEach((item, index) => {
          const card = item.querySelector('.p-shop__card');
          const image = item.querySelector('.p-shop__image');
          const content = item.querySelector('.p-shop__content');
          
          const delay = 0.4 + (index * 0.1); // タイトル・説明文の後、0.1秒間隔
          
          if (card) {
            tl.to(card, {
              opacity: 1,
              y: 0,
              scale: 1,
              duration: 0.6,
              ease: 'power2.out'
            }, delay);
          }
          
          // 画像のズームイン効果
          if (image) {
            tl.to(image, {
              scale: 1,
              duration: 0.8,
              ease: 'power2.out'
            }, delay);
          }
          
          // コンテンツのフェードイン
          if (content) {
            tl.to(content, {
              opacity: 1,
              y: 0,
              duration: 0.5,
              ease: 'power2.out'
            }, delay + 0.2);
          }
        });
      }
    });
    
    // ホバー時のアニメーション強化（GSAPで滑らかに）
    shopItems.forEach((item) => {
      const card = item.querySelector('.p-shop__card');
      const image = item.querySelector('.p-shop__image');
      
      if (card) {
        card.addEventListener('mouseenter', () => {
          gsap.to(card, {
            y: -8,
            scale: 1.02,
            duration: 0.3,
            ease: 'power2.out'
          });
          
          if (image) {
            gsap.to(image, {
              scale: 1.15,
              duration: 0.5,
              ease: 'power2.out'
            });
          }
        });
        
        card.addEventListener('mouseleave', () => {
          gsap.to(card, {
            y: 0,
            scale: 1,
            duration: 0.3,
            ease: 'power2.out'
          });
          
          if (image) {
            gsap.to(image, {
              scale: 1,
              duration: 0.5,
              ease: 'power2.out'
            });
          }
        });
      }
    });
  }
}

// ============================================
// トップページ：about-introセクションのアニメーション
// ============================================
const aboutIntroSection = document.querySelector('.p-about-intro');
if (aboutIntroSection) {
  const aboutIntroTitle = aboutIntroSection.querySelector('.p-about-intro__title');
  const aboutIntroText = aboutIntroSection.querySelector('.p-about-intro__text');
  
  if (aboutIntroTitle) {
    gsap.set(aboutIntroTitle, {
      opacity: 0,
      y: 20
    });
  }
  
  if (aboutIntroText) {
    gsap.set(aboutIntroText, {
      opacity: 0,
      y: 20
    });
  }
  
  ScrollTrigger.create({
    trigger: aboutIntroSection,
    start: 'top 85%',
    once: true,
    onEnter: () => {
      const tl = gsap.timeline();
      
      if (aboutIntroTitle) {
        tl.to(aboutIntroTitle, {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: 'power2.out'
        });
      }
      
      if (aboutIntroText) {
        tl.to(aboutIntroText, {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: 'power2.out'
        }, 0.15);
      }
    }
  });
}

// ============================================
// トップページ：NEWSセクションのアニメーション
// ============================================
const newsSection = document.querySelector('.p-news');
if (newsSection) {
  const newsTitle = newsSection.querySelector('.p-news__title');
  const newsList = newsSection.querySelector('.p-news__list');
  const newsMore = newsSection.querySelector('.p-news__more');
  const newsItems = newsSection.querySelectorAll('.p-news__item');
  
  if (newsTitle) {
    gsap.set(newsTitle, {
      opacity: 0,
      y: 20
    });
  }
  
  if (newsList) {
    gsap.set(newsList, {
      opacity: 0,
      y: 20
    });
  }
  
  if (newsItems.length > 0) {
    newsItems.forEach((item) => {
      gsap.set(item, {
        opacity: 0,
        y: 15
      });
    });
  }
  
  if (newsMore) {
    gsap.set(newsMore, {
      opacity: 0,
      y: 15
    });
  }
  
  ScrollTrigger.create({
    trigger: newsSection,
    start: 'top 85%',
    once: true,
    onEnter: () => {
      const tl = gsap.timeline();
      
      if (newsTitle) {
        tl.to(newsTitle, {
          opacity: 1,
          y: 0,
          duration: 0.7,
          ease: 'power2.out'
        });
      }
      
      if (newsList) {
        tl.to(newsList, {
          opacity: 1,
          y: 0,
          duration: 0.7,
          ease: 'power2.out'
        }, 0.1);
      }
      
      if (newsItems.length > 0) {
        newsItems.forEach((item, index) => {
          tl.to(item, {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: 'power2.out'
          }, 0.2 + (index * 0.05));
        });
      }
      
      if (newsMore) {
        tl.to(newsMore, {
          opacity: 1,
          y: 0,
          duration: 0.6,
          ease: 'power2.out'
        }, 0.4);
      }
    }
  });
}

// ============================================
// トップページ：6つの特徴セクションのアニメーション
// ============================================
const itemsSection = document.querySelector('.p-items');
if (itemsSection) {
  const itemsTitle = itemsSection.querySelector('.c-sec-title');
  const itemsCards = itemsSection.querySelectorAll('.p-items__item');
  
  if (itemsCards.length > 0) {
    if (itemsTitle) {
      gsap.set(itemsTitle, {
        opacity: 0,
        y: 30
      });
    }
    
    itemsCards.forEach((card, index) => {
      const image = card.querySelector('.p-items__image');
      const body = card.querySelector('.p-items__body');
      
      gsap.set(card, {
        opacity: 0,
        y: 40
      });
      
      if (image) {
        gsap.set(image, {
          opacity: 0,
          scale: 0.95
        });
      }
      
      if (body) {
        gsap.set(body, {
          opacity: 0,
          y: 20
        });
      }
    });
    
    ScrollTrigger.create({
      trigger: itemsSection,
      start: 'top 80%',
      once: true,
      onEnter: () => {
        const tl = gsap.timeline();
        
        if (itemsTitle) {
          tl.to(itemsTitle, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out'
          });
        }
        
        itemsCards.forEach((card, index) => {
          const image = card.querySelector('.p-items__image');
          const body = card.querySelector('.p-items__body');
          
          const delay = 0.3 + (index * 0.1);
          
          tl.to(card, {
            opacity: 1,
            y: 0,
            duration: 0.7,
            ease: 'power2.out'
          }, delay);
          
          if (image) {
            tl.to(image, {
              opacity: 1,
              scale: 1,
              duration: 0.8,
              ease: 'power2.out'
            }, delay);
          }
          
          if (body) {
            tl.to(body, {
              opacity: 1,
              y: 0,
              duration: 0.6,
              ease: 'power2.out'
            }, delay + 0.1);
          }
        });
      }
    });
  }
}

// ============================================
// トップページ：みのりオリジナル商品セクションのアニメーション
// ============================================
const originalsSection = document.querySelector('.p-originals');
if (originalsSection) {
  const originalsTitle = originalsSection.querySelector('.c-sec-title');
  const originalsCards = originalsSection.querySelectorAll('.p-items-card__card');
  
  if (originalsCards.length > 0) {
    if (originalsTitle) {
      gsap.set(originalsTitle, {
        opacity: 0,
        y: 30
      });
    }
    
    originalsCards.forEach((card, index) => {
      gsap.set(card, {
        opacity: 0,
        y: 30,
        scale: 0.95
      });
    });
    
    ScrollTrigger.create({
      trigger: originalsSection,
      start: 'top 80%',
      once: true,
      onEnter: () => {
        const tl = gsap.timeline();
        
        if (originalsTitle) {
          tl.to(originalsTitle, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out'
          });
        }
        
        originalsCards.forEach((card, index) => {
          tl.to(card, {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.6,
            ease: 'power2.out'
          }, 0.3 + (index * 0.08));
        });
      }
    });
  }
}

// ============================================
// トップページ：インフォメーションセクションのアニメーション
// ============================================
const infoSection = document.querySelector('.p-info');
if (infoSection) {
  const flowSection = infoSection.querySelector('.p-info__flow');
  const faqSection = infoSection.querySelector('.p-info__faq');
  const flowTitle = flowSection ? flowSection.querySelector('.c-sec-title') : null;
  const faqTitle = faqSection ? faqSection.querySelector('.c-sec-title') : null;
  const flowSteps = flowSection ? flowSection.querySelectorAll('.p-info__flow-step') : [];
  const faqItems = faqSection ? faqSection.querySelectorAll('.p-info__faq-item') : [];
  
  if (flowSection && flowTitle) {
    const flowCta = flowSection.querySelector('.p-info__flow-cta');
    const flowButton = flowCta ? flowCta.querySelector('.c-button') : null;
    
    gsap.set(flowTitle, {
      opacity: 0,
      y: 30
    });
    
    if (flowButton) {
      gsap.set(flowButton, {
        opacity: 0,
        y: 20,
        scale: 0.95
      });
    }
    
    flowSteps.forEach((step, index) => {
      const number = step.querySelector('.p-info__flow-number');
      const line = step.querySelector('.p-info__flow-line');
      const content = step.querySelector('.p-info__flow-content');
      
      gsap.set(step, {
        opacity: 0
      });
      
      if (number) {
        gsap.set(number, {
          scale: 0,
          opacity: 0
        });
      }
      
      if (line) {
        gsap.set(line, {
          scaleY: 0,
          transformOrigin: 'top'
        });
      }
      
      if (content) {
        gsap.set(content, {
          opacity: 0,
          x: -20
        });
      }
    });
    
    ScrollTrigger.create({
      trigger: flowSection,
      start: 'top 80%',
      once: true,
      onEnter: () => {
        const tl = gsap.timeline();
        
        tl.to(flowTitle, {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: 'power3.out'
        });
        
        flowSteps.forEach((step, index) => {
          const number = step.querySelector('.p-info__flow-number');
          const line = step.querySelector('.p-info__flow-line');
          const content = step.querySelector('.p-info__flow-content');
          
          const delay = 0.3 + (index * 0.15);
          
          tl.to(step, {
            opacity: 1,
            duration: 0.3,
            ease: 'power2.out'
          }, delay);
          
          if (number) {
            tl.to(number, {
              scale: 1,
              opacity: 1,
              duration: 0.5,
              ease: 'back.out(1.4)'
            }, delay);
          }
          
          if (line) {
            tl.to(line, {
              scaleY: 1,
              duration: 0.6,
              ease: 'power2.out'
            }, delay + 0.2);
          }
          
          if (content) {
            tl.to(content, {
              opacity: 1,
              x: 0,
              duration: 0.6,
              ease: 'power2.out'
            }, delay + 0.1);
          }
        });
        
        if (flowButton) {
          const lastStepDelay = 0.3 + ((flowSteps.length - 1) * 0.15) + 0.5;
          tl.to(flowButton, {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.6,
            ease: 'back.out(1.4)'
          }, lastStepDelay);
        }
      }
    });
  }
  
  if (faqSection && faqTitle) {
    gsap.set(faqTitle, {
      opacity: 0,
      y: 30
    });
    
    faqItems.forEach((item) => {
      gsap.set(item, {
        opacity: 0,
        y: 20
      });
    });
    
    ScrollTrigger.create({
      trigger: faqSection,
      start: 'top 80%',
      once: true,
      onEnter: () => {
        const tl = gsap.timeline();
        
        tl.to(faqTitle, {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: 'power3.out'
        });
        
        faqItems.forEach((item, index) => {
          tl.to(item, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out'
          }, 0.3 + (index * 0.05));
        });
      }
    });
  }
}

