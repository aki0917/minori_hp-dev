// 企業理念テキストのアニメーション候補集
// 各アニメーション関数を実装して、main.jsで選択して使用できます

// ============================================
// 候補1: 文字ごとに順番にフェードイン（クラシック）
// ============================================
export function animateTextByCharClassic(textElement) {
  const text = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  
  const chars = text.split('');
  chars.forEach((char, index) => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char; // スペースを保持
    span.style.display = 'inline-block';
    span.style.opacity = '0';
    textElement.appendChild(span);
    
    gsap.to(span, {
      opacity: 1,
      y: 0,
      duration: 0.05,
      delay: index * 0.03,
      ease: 'power2.out'
    });
  });
}

// ============================================
// 候補2: 波打つようなアニメーション（エレガント）
// ============================================
export function animateTextWave(textElement) {
  const text = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  
  const chars = text.split('');
  chars.forEach((char, index) => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char;
    span.style.display = 'inline-block';
    span.style.opacity = '0';
    span.style.transform = 'translateY(20px)';
    textElement.appendChild(span);
    
    gsap.to(span, {
      opacity: 1,
      y: 0,
      duration: 0.6,
      delay: index * 0.05,
      ease: 'back.out(1.7)'
    });
  });
}

// ============================================
// 候補3: グラデーションアニメーション（モダン）
// ============================================
export function animateTextGradient(textElement) {
  gsap.set(textElement, {
    opacity: 0,
    background: 'linear-gradient(90deg, #2E7D32 0%, #4CAF50 50%, #2E7D32 100%)',
    backgroundSize: '200% 100%',
    WebkitBackgroundClip: 'text',
    WebkitTextFillColor: 'transparent',
    backgroundClip: 'text'
  });
  
  const tl = gsap.timeline();
  tl.to(textElement, {
    opacity: 1,
    duration: 0.8,
    ease: 'power2.out'
  })
  .to(textElement, {
    backgroundPosition: '200% 0',
    duration: 2,
    ease: 'none',
    repeat: -1
  }, 0.5);
}

// ============================================
// 候補4: 光が流れるアニメーション（プレミアム）
// ============================================
export function animateTextShine(textElement) {
  // テキストをspanで囲む
  const wrapper = document.createElement('span');
  wrapper.style.position = 'relative';
  wrapper.style.display = 'inline-block';
  textElement.parentNode.insertBefore(wrapper, textElement);
  wrapper.appendChild(textElement);
  
  // 光るエフェクト用の要素を作成
  const shine = document.createElement('span');
  shine.style.position = 'absolute';
  shine.style.top = '0';
  shine.style.left = '-100%';
  shine.style.width = '100%';
  shine.style.height = '100%';
  shine.style.background = 'linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent)';
  shine.style.transform = 'skewX(-20deg)';
  wrapper.appendChild(shine);
  
  gsap.set(textElement, { opacity: 0, y: 20 });
  
  const tl = gsap.timeline({ repeat: -1, repeatDelay: 3 });
  tl.to(textElement, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: 'power2.out'
  })
  .to(shine, {
    left: '200%',
    duration: 1.5,
    ease: 'power2.inOut'
  }, 1);
}

// ============================================
// 候補5: 文字が浮き上がるアニメーション（エレガント）
// ============================================
export function animateTextFloat(textElement) {
  const text = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  
  const words = text.split(/(\s+)/);
  words.forEach((word, wordIndex) => {
    const wordSpan = document.createElement('span');
    wordSpan.style.display = 'inline-block';
    wordSpan.style.marginRight = '0.2em';
    
    if (word.trim()) {
      const chars = word.split('');
      chars.forEach((char, charIndex) => {
        const span = document.createElement('span');
        span.textContent = char;
        span.style.display = 'inline-block';
        span.style.opacity = '0';
        span.style.transform = 'translateY(30px) rotateX(90deg)';
        wordSpan.appendChild(span);
        
        gsap.to(span, {
          opacity: 1,
          y: 0,
          rotationX: 0,
          duration: 0.5,
          delay: (wordIndex * 0.1) + (charIndex * 0.03),
          ease: 'back.out(1.5)'
        });
      });
    } else {
      wordSpan.textContent = word;
    }
    
    textElement.appendChild(wordSpan);
  });
}

// ============================================
// 候補6: タイピングエフェクト（クラシック）
// ============================================
export function animateTextTyping(textElement) {
  const fullText = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  
  let currentIndex = 0;
  const typingSpeed = 50; // ミリ秒
  
  function typeChar() {
    if (currentIndex < fullText.length) {
      textElement.textContent += fullText[currentIndex];
      currentIndex++;
      setTimeout(typeChar, typingSpeed);
    }
  }
  
  typeChar();
}

// ============================================
// 候補7: 3D回転アニメーション（ダイナミック）
// ============================================
export function animateText3D(textElement) {
  const text = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  textElement.style.perspective = '1000px';
  
  const chars = text.split('');
  chars.forEach((char, index) => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char;
    span.style.display = 'inline-block';
    span.style.opacity = '0';
    span.style.transform = 'rotateY(90deg) translateZ(50px)';
    textElement.appendChild(span);
    
    gsap.to(span, {
      opacity: 1,
      rotationY: 0,
      z: 0,
      duration: 0.6,
      delay: index * 0.05,
      ease: 'back.out(1.4)'
    });
  });
}

// ============================================
// 候補8: フェードイン＋スケール（シンプルエレガント）
// ============================================
export function animateTextFadeScale(textElement) {
  gsap.set(textElement, {
    opacity: 0,
    scale: 0.8,
    y: 20
  });
  
  gsap.to(textElement, {
    opacity: 1,
    scale: 1,
    y: 0,
    duration: 1.2,
    ease: 'power3.out'
  });
  
  // ホバー時に軽く動く
  textElement.addEventListener('mouseenter', () => {
    gsap.to(textElement, {
      scale: 1.02,
      duration: 0.3,
      ease: 'power2.out'
    });
  });
  
  textElement.addEventListener('mouseleave', () => {
    gsap.to(textElement, {
      scale: 1,
      duration: 0.3,
      ease: 'power2.out'
    });
  });
}

// ============================================
// 候補9: 文字が散らばって集まる（プレイフル）
// ============================================
export function animateTextScatter(textElement) {
  const text = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  
  const chars = text.split('');
  chars.forEach((char, index) => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char;
    span.style.display = 'inline-block';
    span.style.position = 'relative';
    
    // ランダムな初期位置
    const angle = (Math.PI * 2 * index) / chars.length;
    const distance = 100;
    const x = Math.cos(angle) * distance;
    const y = Math.sin(angle) * distance;
    
    gsap.set(span, {
      x: x,
      y: y,
      opacity: 0,
      rotation: angle * (180 / Math.PI)
    });
    
    textElement.appendChild(span);
    
    gsap.to(span, {
      x: 0,
      y: 0,
      opacity: 1,
      rotation: 0,
      duration: 0.8,
      delay: index * 0.02,
      ease: 'elastic.out(1, 0.5)'
    });
  });
}

// ============================================
// 候補10: グラデーション＋文字アニメーション（ハイブリッド）
// ============================================
export function animateTextHybrid(textElement) {
  const text = textElement.textContent;
  textElement.textContent = '';
  textElement.style.opacity = '1';
  
  const chars = text.split('');
  chars.forEach((char, index) => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char;
    span.style.display = 'inline-block';
    span.style.background = 'linear-gradient(135deg, #2E7D32, #4CAF50)';
    span.style.WebkitBackgroundClip = 'text';
    span.style.WebkitTextFillColor = 'transparent';
    span.style.backgroundClip = 'text';
    span.style.opacity = '0';
    span.style.transform = 'translateY(20px) scale(0.8)';
    textElement.appendChild(span);
    
    gsap.to(span, {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 0.5,
      delay: index * 0.04,
      ease: 'back.out(1.6)'
    });
  });
}





