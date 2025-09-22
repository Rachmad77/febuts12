document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("header");
    const menuBar = document.querySelector(".menu-bar");
    const menu = document.querySelector(".menu");
    const items = document.querySelectorAll(".menu > li");

    const closeAll = () => items.forEach((li) => li.classList.remove("open"));

    // ---- Scroll efek header ----
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) header.classList.add("scrolled");
        else header.classList.remove("scrolled");
    });

    // ---- Toggle menu utama (hamburger) ----
    menuBar.addEventListener("click", () => {
        menu.classList.toggle("active");
    });

    // ---- Dropdown: KLIK untuk MOBILE & DESKTOP ----
    // (hanya elemen yang punya .menu-toggle yang diproses)
    menu.addEventListener("click", function (e) {
        const toggle = e.target.closest(".menu > li > .menu-toggle");
        if (!toggle) return;

        // blok navigasi untuk toggle (biar buka/tutup dropdown dulu)
        e.preventDefault();
        e.stopPropagation();

        const li = toggle.parentElement;
        const isOpen = li.classList.contains("open");

        // Tutup semua lalu buka yang diklik (single-open behavior)
        closeAll();
        if (!isOpen) li.classList.add("open");
    });

    // ---- Klik di luar navbar = tutup semua (mobile & desktop) ----
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".navbar")) closeAll();
    });

    // ---- ESC untuk nutup semua ----
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") closeAll();
    });

    // ---- Reset saat resize ke desktop ----
    window.addEventListener("resize", function () {
        if (window.innerWidth > 992) {
            menu.classList.remove("active");
            closeAll();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".slide");
    const dotsContainer = document.querySelector(".dots");
    let currentIndex = 0;
    let slideInterval;

    if (slides.length === 0) return; // kalau tidak ada slide, keluar

    // buat dots sesuai jumlah slide
    slides.forEach((_, i) => {
        const dot = document.createElement("span");
        if (i === 0) dot.classList.add("active");
        dot.addEventListener("click", () => {
            goToSlide(i, true); // true = manual klik
        });
        dotsContainer.appendChild(dot);
    });
    const dots = dotsContainer.querySelectorAll("span");

    function goToSlide(index, isManual = false) {
        slides[currentIndex].classList.remove("active");
        dots[currentIndex].classList.remove("active");

        currentIndex = index;

        slides[currentIndex].classList.add("active");
        dots[currentIndex].classList.add("active");

        if (isManual) {
            resetInterval(); // reset auto-slide kalau manual klik
        }
    }

    function nextSlide() {
        let next = (currentIndex + 1) % slides.length;
        goToSlide(next);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000); // 5 detik ganti slide
    }

    // mulai auto geser
    resetInterval();
});

let currentIndex = 0;
const wrapper = document.getElementById("announcement-wrapper");
const totalItems = document.querySelectorAll(".announcement-item").length;

function updateSlide() {
    wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function nextAnnouncement() {
    currentIndex = (currentIndex + 1) % totalItems;
    updateSlide();
}

function prevAnnouncement() {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    updateSlide();
}

setInterval(nextAnnouncement, 10000); // auto geser tiap 10 detik

var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        576: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        992: {
            slidesPerView: 4,
        },
    },
});

const wrapper_alumni = document.querySelector(".wrapper_alumni");
const carousel_alumni = document.querySelector(".carousel_alumni");
const firstCard_alumniWidth =
    carousel_alumni.querySelector(".card_alumni").offsetWidth;
const arrowBtns = document.querySelectorAll(".wrapper_alumni i");
const carousel_alumniChildrens = [...carousel_alumni.children];

let isDragging = false,
    isAutoPlay = true,
    startX,
    startScrollLeft,
    timeoutId;

// Get the number of card_alumnis that can fit in the carousel_alumni at once
let card_alumniPerView = Math.round(
    carousel_alumni.offsetWidth / firstCard_alumniWidth
);

// Insert copies of the last few card_alumnis to beginning of carousel_alumni for infinite scrolling
carousel_alumniChildrens
    .slice(-card_alumniPerView)
    .reverse()
    .forEach((card_alumni) => {
        carousel_alumni.insertAdjacentHTML("afterbegin", card_alumni.outerHTML);
    });

// Insert copies of the first few card_alumnis to end of carousel_alumni for infinite scrolling
carousel_alumniChildrens.slice(0, card_alumniPerView).forEach((card_alumni) => {
    carousel_alumni.insertAdjacentHTML("beforeend", card_alumni.outerHTML);
});

// Scroll the carousel_alumni at appropriate postition to hide first few duplicate card_alumnis on Firefox
carousel_alumni.classList.add("no-transition");
carousel_alumni.scrollLeft = carousel_alumni.offsetWidth;
carousel_alumni.classList.remove("no-transition");

// Add event listeners for the arrow buttons to scroll the carousel_alumni left and right
arrowBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        carousel_alumni.scrollLeft +=
            btn.id == "left" ? -firstCard_alumniWidth : firstCard_alumniWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    carousel_alumni.classList.add("dragging");
    // Records the initial cursor and scroll position of the carousel_alumni
    startX = e.pageX;
    startScrollLeft = carousel_alumni.scrollLeft;
};

const dragging = (e) => {
    if (!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the carousel_alumni based on the cursor movement
    carousel_alumni.scrollLeft = startScrollLeft - (e.pageX - startX);
};

const dragStop = () => {
    isDragging = false;
    carousel_alumni.classList.remove("dragging");
};

const infiniteScroll = () => {
    // If the carousel_alumni is at the beginning, scroll to the end
    if (carousel_alumni.scrollLeft === 0) {
        carousel_alumni.classList.add("no-transition");
        carousel_alumni.scrollLeft =
            carousel_alumni.scrollWidth - 2 * carousel_alumni.offsetWidth;
        carousel_alumni.classList.remove("no-transition");
    }
    // If the carousel_alumni is at the end, scroll to the beginning
    else if (
        Math.ceil(carousel_alumni.scrollLeft) ===
        carousel_alumni.scrollWidth - carousel_alumni.offsetWidth
    ) {
        carousel_alumni.classList.add("no-transition");
        carousel_alumni.scrollLeft = carousel_alumni.offsetWidth;
        carousel_alumni.classList.remove("no-transition");
    }

    // Clear existing timeout & start autoplay if mouse is not hovering over carousel_alumni
    clearTimeout(timeoutId);
    if (!wrapper_alumni.matches(":hover")) autoPlay();
};

const autoPlay = () => {
    if (window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the carousel_alumni after every 2500 ms
    timeoutId = setTimeout(
        () => (carousel_alumni.scrollLeft += firstCard_alumniWidth),
        2500
    );
};
autoPlay();

carousel_alumni.addEventListener("mousedown", dragStart);
carousel_alumni.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel_alumni.addEventListener("scroll", infiniteScroll);
wrapper_alumni.addEventListener("mouseenter", () => clearTimeout(timeoutId));
wrapper_alumni.addEventListener("mouseleave", autoPlay);
