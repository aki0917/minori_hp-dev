  <footer class="l-footer" role="contentinfo">
    <div class="l-footer__inner">
      <div class="l-footer__content">
        <div class="l-footer__section l-footer__section--logo">
          <h2 class="l-footer__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="農家の店みのりFARM &amp; GARDEN ホーム">
              <?php echo minorihp_get_picture_tag(
                get_template_directory_uri() . '/assets/img/common/logo-1.png',
                '農家の店みのりFARM &amp; GARDEN',
                array( 'width' => '927', 'height' => '269', 'loading' => 'lazy', 'fetchpriority' => '', 'decoding' => 'async' )
              ); ?>
            </a>
          </h2>
          <p class="l-footer__description">
            農業資材、農薬、肥料、機械など生産資材から、野菜・花の種や苗を扱う大型の専門店です。<br>
            栃木県、茨城県に9店舗を展開しており、取り扱いアイテム数は3万点以上です。
          </p>
        </div>

        <div class="l-footer__section l-footer__section--nav">
          <h3 class="l-footer__title">各種お取り引き</h3>
          <nav class="l-footer__nav">
            <ul class="l-footer__nav-list">
              <li class="l-footer__nav-item">
                <a
                  href="<?php echo esc_url( 'https://docs.google.com/forms/d/e/1FAIpQLSfsL5eu1lI5o3qSn2G_DAv5XI0kKAHuCSO-j2fSJIzixRBDxQ/viewform' ); ?>"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="l-footer__nav-link"
                >商材募集</a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="l-footer__section l-footer__section--shop">
          <h3 class="l-footer__title">ネット販売</h3>
          <p class="l-footer__shop-description">
            <a href="<?php echo esc_url( 'https://www.rakuten.co.jp/kminori/' ); ?>" target="_blank" rel="noopener noreferrer" class="l-footer__shop-link">農家の店みのり楽天市場店</a>
          </p>
          <p class="l-footer__shop-description">
            <a href="<?php echo esc_url( 'https://store.shopping.yahoo.co.jp/noyaku-com/' ); ?>" target="_blank" rel="noopener noreferrer" class="l-footer__shop-link">農薬ドットコム Yahoo!ショッピング</a>
          </p>
          <p class="l-footer__shop-description">
            <a href="<?php echo esc_url( 'https://www.amazon.co.jp/s?i=merchant-items&me=A2EFHFKX98OBK5' ); ?>" target="_blank" rel="noopener noreferrer" class="l-footer__shop-link">農家の店みのりAmazon店</a>
          </p>
        </div>

        <div class="l-footer__section l-footer__section--info">
          <div class="l-footer__info">
            <div class="l-footer__social">
              <h4 class="l-footer__social-title">農家の店みのり楽天公式SNS</h4>
              <ul class="l-footer__social-list">
                <li class="l-footer__social-item">
                  <a href="https://line.me/R/ti/p/%40467urwgf" target="_blank" rel="noopener noreferrer" class="l-footer__social-link" aria-label="LINE">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_line.svg' ); ?>" alt="LINE" width="24" height="24">
                  </a>
                </li>
              </ul>
            </div>

            <div class="l-footer__social">
              <h4 class="l-footer__social-title">農薬ドットコム公式SNS</h4>
              <ul class="l-footer__social-list">
                <li class="l-footer__social-item">
                  <a href="https://lin.ee/wwMqoVk" target="_blank" rel="noopener noreferrer" class="l-footer__social-link" aria-label="LINE">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_line.svg' ); ?>" alt="LINE" width="24" height="24">
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="l-footer__copyright">
        <p class="l-footer__copyright-text">
          &copy; <?php echo esc_html( date( 'Y' ) ); ?> 農家の店みのり FARM &amp; GARDEN. All rights reserved.
        </p>
      </div>
    </div>
  </footer>

  <div class="p-services-modal" id="servicesModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="p-services-modal__overlay"></div>
    <div class="p-services-modal__content">
      <button class="p-services-modal__close" aria-label="閉じる">&times;</button>
      <div class="p-services-modal__image-wrapper">
        <img class="p-services-modal__image" src="" alt="" id="modalImage" hidden>
      </div>
      <h3 class="p-services-modal__title" id="modalTitle"></h3>
      <div class="p-services-modal__body" id="modalBody"></div>
    </div>
  </div>

  <?php wp_footer(); ?>
</body>
</html>

