document.addEventListener("DOMContentLoaded", function () {
    const track = document.querySelector(".image-track");
    const dots = document.querySelectorAll(".dot");
    if (!track || dots.length === 0) return;

    const slideWidth = track.clientWidth;

    // ドットクリックでスライド
    dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
            track.scrollTo({
                left: i * slideWidth,
                behavior: "smooth",
            });
            updateDots(i);
        });
    });

    // スクロールでアクティブドット更新
    track.addEventListener("scroll", () => {
        const index = Math.round(track.scrollLeft / slideWidth);
        updateDots(index);
    });

    function updateDots(activeIndex) {
        dots.forEach((dot, i) => {
            dot.classList.toggle("active", i === activeIndex);
        });
    }

    // 初期アクティブ設定
    updateDots(0);
});
