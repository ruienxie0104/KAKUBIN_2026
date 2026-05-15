document.addEventListener('DOMContentLoaded', () => {
  // Elements
  const phase1 = document.getElementById('phase-1');
  const phase2 = document.getElementById('phase-2');
  const phase3 = document.getElementById('phase-3');
  const phase4 = document.getElementById('phase-4');
  const phase5 = document.getElementById('phase-5'); // Phase 5 & 6 share the same container
  
  const btnAgeYes = document.getElementById('btn-age-yes');
  const btnAgeNo = document.getElementById('btn-age-no');
  const btnStart = document.getElementById('btn-start');
  const formAgreement = document.getElementById('form-agreement');
  const vidShuffle = document.getElementById('vid-shuffle');
  
  const resultCard = document.getElementById('result-card');
  const resultText = document.getElementById('result-text');
  const stampRedeemed = document.getElementById('stamp-redeemed');
  const btnSimulate = document.getElementById('btn-simulate');

  // Cards & Flavors Mapping
  const cards = [
    { src: 'img/花札牌-01.png', flavor: '經典' },
    { src: 'img/花札牌-02.png', flavor: '紫蘇' },
    { src: 'img/花札牌-03.png', flavor: '鳳梨' },
    { src: 'img/花札牌-04.png', flavor: '柚子' }
  ];

  // Utility to switch phases
  function switchPhase(fromLayer, toLayer) {
    if (fromLayer) {
      fromLayer.classList.remove('active');
      // Wait for fade out
      setTimeout(() => {
        fromLayer.classList.add('hidden-phase');
      }, 500);
    }
    
    if (toLayer) {
      toLayer.classList.remove('hidden');
      toLayer.classList.remove('hidden-phase');
      // Small delay to allow display to apply before opacity transition
      setTimeout(() => {
        toLayer.classList.add('active');
      }, 50);
      
      // Manage global banner visibility
      const globalBanner = document.getElementById('global-banner');
      if (globalBanner) {
        if (toLayer.id === 'phase-2' || toLayer.id === 'phase-1') {
          globalBanner.classList.add('hidden');
        } else {
          globalBanner.classList.remove('hidden');
        }
      }
    }
  }

  // Phase 1: Age Gate Logic
  btnAgeNo.addEventListener('click', () => {
    alert('需年滿18歲才能進入喔！');
  });

  btnAgeYes.addEventListener('click', () => {
    // Fade out phase 1 (overlay)
    phase1.style.opacity = '0';
    setTimeout(() => {
      phase1.classList.add('hidden');
      // Ensure phase 2 is active
      phase2.classList.remove('hidden');
      phase2.classList.remove('hidden-phase');
      phase2.classList.add('active');
    }, 500);
  });

  // Phase 2 -> Phase 3
  btnStart.addEventListener('click', () => {
    switchPhase(phase2, phase3);
  });

  // Phase 3 Form Submission -> Phase 4 (Wait for click)
  formAgreement.addEventListener('submit', (e) => {
    e.preventDefault();
    // In a real app, we'd send data to a server here.
    
    // Switch to Animation Phase
    switchPhase(phase3, phase4);
    
    // Reset video and overlay state
    vidShuffle.currentTime = 0;
    const overlay = document.getElementById('phase-4-overlay');
    overlay.style.display = ''; // Reset display none
    overlay.style.opacity = '1';
    overlay.classList.add('animate-pulse'); // Add back animation
  });

  // Phase 4 Click to Draw -> Play Video
  phase4.addEventListener('click', () => {
    // Hide overlay and remove animation to prevent it from reappearing
    const overlay = document.getElementById('phase-4-overlay');
    overlay.classList.remove('animate-pulse');
    overlay.style.opacity = '0';
    
    // Completely hide from DOM after fade out
    setTimeout(() => {
      overlay.style.display = 'none';
    }, 300);
    
    // Play video
    vidShuffle.play().catch(err => {
      console.warn("Autoplay prevented:", err);
      vidShuffle.dispatchEvent(new Event('ended'));
    });
  }, { once: true }); // Ensure it only triggers once per phase cycle

  // Phase 4 Video Ended -> Phase 5
  vidShuffle.addEventListener('ended', () => {
    // Randomize Card
    const randomCard = cards[Math.floor(Math.random() * cards.length)];
    resultCard.src = randomCard.src;
    resultText.innerHTML = `恭喜獲得 <span class="text-danger">${randomCard.flavor}</span> Highball 一杯`;
    
    switchPhase(phase4, phase5);
  });

  // Phase 5 -> Phase 6 (Simulate Redemption)
  btnSimulate.addEventListener('click', () => {
    stampRedeemed.style.opacity = '1';
    stampRedeemed.style.transform = 'scale(1)';
    btnSimulate.style.display = 'none'; // Hide button after redeemed
  });

  // Init Phase 2 as active (underneath Phase 1 overlay)
  phase2.classList.add('active');
});
