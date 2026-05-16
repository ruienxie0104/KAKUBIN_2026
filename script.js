document.addEventListener('DOMContentLoaded', () => {
  // Page Fade-in on load
  const bodyMain = document.getElementById('body-main');
  if (bodyMain) {
    // Add a slight delay to ensure CSS has loaded
    setTimeout(() => {
      bodyMain.style.opacity = '1';
    }, 50);
  }

  // Utility to handle page transitions (fade out then redirect)
  function navigateTo(url) {
    if (bodyMain) {
      bodyMain.style.opacity = '0';
      setTimeout(() => {
        window.location.href = url;
      }, 500); // Matches the duration-500 class
    } else {
      window.location.href = url;
    }
  }

  // Cards & Flavors Mapping
  const cards = [
    { src: 'img/花札牌-01.png', flavor: '經典' },
    { src: 'img/花札牌-02.png', flavor: '紫蘇' },
    { src: 'img/花札牌-03.png', flavor: '鳳梨' },
    { src: 'img/花札牌-04.png', flavor: '柚子' }
  ];

  // ---------- index.html Logic ----------
  const phase1 = document.getElementById('phase-1');
  const btnAgeYes = document.getElementById('btn-age-yes');
  const btnAgeNo = document.getElementById('btn-age-no');
  const btnStart = document.getElementById('btn-start');

  if (btnAgeNo) {
    btnAgeNo.addEventListener('click', () => {
      alert('需年滿18歲才能進入喔！');
    });
  }

  if (btnAgeYes) {
    btnAgeYes.addEventListener('click', () => {
      // Fade out phase 1 (Age Gate overlay)
      phase1.style.opacity = '0';
      setTimeout(() => {
        phase1.style.display = 'none';
      }, 500);
    });
  }

  if (btnStart) {
    btnStart.addEventListener('click', () => {
      navigateTo('draw.html');
    });
  }


  // ---------- draw.html Logic ----------
  const phase3 = document.getElementById('phase-3');
  const phase4 = document.getElementById('phase-4');
  const formAgreement = document.getElementById('form-agreement');
  const vidShuffle = document.getElementById('vid-shuffle');
  const agreeCheckbox = document.getElementById('agree');
  
  // Policy Modal Elements
  const btnOpenPolicy = document.getElementById('btn-open-policy');
  const policyModal = document.getElementById('policy-modal');
  const btnClosePolicy = document.getElementById('btn-close-policy');
  const modalPrivacyConsent = document.getElementById('modal-privacy-consent');

  // Modal Open/Close Logic
  if (btnOpenPolicy && policyModal) {
    btnOpenPolicy.addEventListener('click', () => {
      policyModal.classList.remove('hidden');
      setTimeout(() => {
        policyModal.classList.remove('opacity-0', 'pointer-events-none');
      }, 10);
    });
  }

  function closePolicyModal() {
    if (policyModal) {
      policyModal.classList.add('opacity-0', 'pointer-events-none');
      setTimeout(() => {
        policyModal.classList.add('hidden');
      }, 300);
    }
  }

  if (btnClosePolicy) {
    btnClosePolicy.addEventListener('click', closePolicyModal);
  }

  // Sync Checkboxes
  if (modalPrivacyConsent && agreeCheckbox) {
    modalPrivacyConsent.addEventListener('change', function() {
      agreeCheckbox.checked = this.checked;
      if (this.checked) {
        // Close modal automatically if they checked it inside the modal
        setTimeout(closePolicyModal, 300);
      }
    });

    agreeCheckbox.addEventListener('change', function() {
      modalPrivacyConsent.checked = this.checked;
    });
  }

  if (formAgreement) {
    formAgreement.addEventListener('submit', (e) => {
      e.preventDefault();
      
      // Switch from Phase 3 to Phase 4 (within same page)
      phase3.style.opacity = '0';
      setTimeout(() => {
        phase3.style.display = 'none';
        
        phase4.style.display = 'flex';
        // Small delay to allow display to apply before opacity transition
        setTimeout(() => {
          phase4.style.opacity = '1';
        }, 50);
        
        // Reset video and overlay state
        vidShuffle.currentTime = 0;
        const overlay = document.getElementById('phase-4-overlay');
        overlay.style.display = ''; 
        overlay.style.opacity = '1';
        overlay.classList.add('animate-pulse');
      }, 500);
    });
  }

  if (phase4) {
    phase4.addEventListener('click', () => {
      // Hide overlay and remove animation
      const overlay = document.getElementById('phase-4-overlay');
      overlay.classList.remove('animate-pulse');
      overlay.style.opacity = '0';
      
      setTimeout(() => {
        overlay.style.display = 'none';
      }, 300);
      
      // Play video
      vidShuffle.play().catch(err => {
        console.warn("Autoplay prevented:", err);
        vidShuffle.dispatchEvent(new Event('ended'));
      });
    }, { once: true });

    vidShuffle.addEventListener('ended', () => {
      // Navigate to result.html after video finishes
      navigateTo('result.html');
    });
  }


  // ---------- result.html Logic ----------
  const resultCard = document.getElementById('result-card');
  const resultText = document.getElementById('result-text');
  const stampRedeemed = document.getElementById('stamp-redeemed');
  const btnSimulate = document.getElementById('btn-simulate');

  // Randomize card on load if we are on result page
  if (resultCard && resultText) {
    const randomCard = cards[Math.floor(Math.random() * cards.length)];
    resultCard.src = randomCard.src;
    resultText.innerHTML = `恭喜獲得 <span class="text-danger">${randomCard.flavor}</span> Highball 一杯`;
  }

  if (btnSimulate) {
    btnSimulate.addEventListener('click', () => {
      stampRedeemed.style.opacity = '1';
      stampRedeemed.style.transform = 'scale(1)';
      btnSimulate.style.display = 'none'; // Hide button after redeemed
    });
  }

});
