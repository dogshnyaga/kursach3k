document.querySelectorAll("input.btn-cart").forEach((input) => {
  const wrapper = document.createElement("span");
  wrapper.className = "input-cart-wrapper";
  input.parentNode.insertBefore(wrapper, input);
  wrapper.appendChild(input);
});

window.addEventListener("scroll", function () {
  const header = document.getElementById("fixedHeader");
  if (window.scrollY > 0) {
    header.style.backgroundColor = "white";
  } else {
    header.style.backgroundColor = "transparent";
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const reviewsContainer = document.querySelector(".reviews");
  const feedbackCards = document.querySelectorAll(".feedback-card");
  const prevBtn = document.getElementById("slider-btn-prev");
  const nextBtn = document.getElementById("slider-btn-next");
  let currentIndex = 0;
  let isMobile = window.innerWidth <= 480;
  let touchStartX = 0;
  let touchEndX = 0;
  const cardsToShow = isMobile ? 1 : 2;
  const totalCards = feedbackCards.length;

  function initSlider() {
    updateSlider();
    setupEventListeners();
    updateButtonStates();
  }

  function updateSlider() {
    feedbackCards.forEach((card, index) => {
      card.classList.remove("active", "dimmed");

      if (isMobile) {
        if (index === currentIndex) {
          card.classList.add("active");
        }
      } else {
        if (index === currentIndex || index === currentIndex + 1) {
          card.classList.add("active");
        } else {
          card.classList.add("dimmed");
        }
      }
    });

    const cardWidth = feedbackCards[0].offsetWidth;
    const translateValue = -currentIndex * cardWidth * (isMobile ? 1 : 0.5);
    reviewsContainer.style.transform = `translateX(${translateValue}px)`;
  }

  function updateButtonStates() {
    if (!isMobile) {
      prevBtn.disabled = currentIndex === 0;
      nextBtn.disabled = currentIndex >= totalCards - cardsToShow;
    }
  }

  function prevSlide() {
    if (currentIndex > 0) {
      currentIndex--;
      updateSlider();
      updateButtonStates();
    } else if (isMobile && currentIndex === 0) {
      currentIndex = totalCards - 1;
      updateSlider();
    }
  }

  function nextSlide() {
    if (isMobile) {
      if (currentIndex < totalCards - 1) {
        currentIndex++;
      } else {
        currentIndex = 0;
      }
    } else {
      if (currentIndex < totalCards - cardsToShow) {
        currentIndex++;
      }
    }
    updateSlider();
    updateButtonStates();
  }

  function handleSwipe() {
    const difference = touchStartX - touchEndX;
    if (difference > 50) {
      nextSlide();
    } else if (difference < -50) {
      prevSlide();
    }
  }

  function setupEventListeners() {
    if (!isMobile) {
      prevBtn.addEventListener("click", prevSlide);
      nextBtn.addEventListener("click", nextSlide);
    } else {
      prevBtn.style.display = "none";
      nextBtn.style.display = "none";

      reviewsContainer.addEventListener(
        "touchstart",
        (e) => {
          touchStartX = e.changedTouches[0].screenX;
        },
        false
      );

      reviewsContainer.addEventListener(
        "touchend",
        (e) => {
          touchEndX = e.changedTouches[0].screenX;
          handleSwipe();
        },
        false
      );
    }
  }

  initSlider();
});
// Модальные окна авторизации
const loginModal = document.getElementById("loginModal");
const registerModal = document.getElementById("registerModal");
const openLoginBtn = document.getElementById("openModalLogin");
const openRegBtn = document.getElementById("openModalReg");
const closeBtns = document.querySelectorAll(".close-btn");
const switchToRegister = document.getElementById("switchToRegister");
const switchToLogin = document.getElementById("switchToLogin");

// Общие функции для работы с модальными окнами
function openModal(modal) {
  if (modal) modal.style.display = "flex";
}

function closeModal(modal) {
  if (modal) modal.style.display = "none";
}

function setupModal(openBtn, modal) {
  if (openBtn && modal) {
    openBtn.addEventListener("click", () => openModal(modal));
  }
}

// Настройка модальных окон авторизации
if (openLoginBtn && loginModal) setupModal(openLoginBtn, loginModal);
if (openRegBtn && registerModal) setupModal(openRegBtn, registerModal);

// Закрытие модальных окон при клике на крестик или кнопку отмены
document.querySelectorAll(".close-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const modalId = this.getAttribute("data-modal");
    if (modalId) {
      const modal = document.getElementById(modalId);
      closeModal(modal);
    }
  });
});

// Закрытие при клике вне модального окна
window.addEventListener("click", (event) => {
  if (loginModal && event.target === loginModal) closeModal(loginModal);
  if (registerModal && event.target === registerModal)
    closeModal(registerModal);
});

// Закрытие при нажатии Esc
document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    closeModal(loginModal);
    closeModal(registerModal);
  }
});
if (switchToRegister && loginModal && registerModal) {
  switchToRegister.addEventListener("click", (e) => {
    e.preventDefault();
    closeModal(loginModal);
    openModal(registerModal);
  });
}

if (switchToLogin && registerModal && loginModal) {
  switchToLogin.addEventListener("click", (e) => {
    e.preventDefault();
    closeModal(registerModal);
    openModal(loginModal);
  });
}

